<?php

namespace App\Http\Livewire;

use App\Mail\UserInvited;
use Livewire\Component;
use App\Restaurant;
use App\User;

use Illuminate\Support\Facades\Mail;

class AddAccount extends Component
{
    public $searchTerm;
    public $anon_name;
    public $restaurant;
    public $users;
    public $action_button_text;
    public $is_disabled;
    public $anon_is_disabled;

    public function mount(Restaurant $restaurant)
    {
        $this->restaurant = $restaurant;

        $this->action_button_text = 'add';
        $this->is_disabled = true;
    }

    public function updated($field)
    {
        $this->validateOnly($field, [
            'searchTerm' => 'email',
        ]);
    }

    public function addAccount()
    {
        $this->validate([
            'searchTerm' => 'email|required',
        ]);

        $message = __('messages.went_wrong');

        $user_to_add = User::where('email', $this->searchTerm)->first();
        if ($user_to_add) {
            $this->restaurant->users()->attach($user_to_add->id, ['role' => 'user']);
            $message = __('messages.user_added', [
                'user_name' => $user_to_add->name,
                'user_email' => $user_to_add->email,
            ]);
        } else {
            $invited_user = User::create([
                'email' => $this->searchTerm,
                'name' => $this->searchTerm,
                'type' => 'invited',
            ]);
            $this->restaurant->users()->attach($invited_user->id, ['role' => 'user']);
            Mail::to($invited_user->email)->send(new UserInvited($this->restaurant, $invited_user));
            $message = __('messages.user_invited', ['user_email' => $user_to_add->email]);
        }
        $this->emitTo('edit-restaurant', 'userAdded', $message);
        $this->dispatchBrowserEvent('close-add-account');
    }

    public function addAnonymousAccount()
    {
        $anonymous_user = User::create([
            'name' => $this->anon_name,
            'type' => 'anonymous',
        ]);

        $anonymous_user->email = 'anonymous@' . $anonymous_user->id;
        $anonymous_user->save();
        $this->restaurant->users()->attach($anonymous_user->id, ['role' => 'user']);
        $this->emitTo('edit-restaurant', 'userAdded', __('messages.employee_added', ['name' => $anonymous_user->name]));
        $this->dispatchBrowserEvent('close-add-account');
    }

    public function render()
    {
        if ($this->searchTerm && strlen($this->searchTerm) > 2) {
            $searchTerm = '%' . $this->searchTerm . '%';
            $this->users = User::where('email', 'like', $searchTerm)->get();
            $this->action_button_text = sizeof($this->users) > 0 ? __('messages.add') : __('messages.invite');
            $this->is_disabled = false;
        } else {
            $this->is_disabled = true;
        }

        $this->anon_is_disabled = strlen($this->anon_name) == 0;

        return view('livewire.add-account');
    }
}
