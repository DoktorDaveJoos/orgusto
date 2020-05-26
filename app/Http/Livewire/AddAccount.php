<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Restaurant;
use App\User;

class AddAccount extends Component
{

    public $searchTerm;
    public $restaurant;
    public $users;

    public function mount(Restaurant $restaurant)
    {
        $this->restaurant = $restaurant;
    }

    public function addAccount()
    {
        $message = 'Something went wrong';

        $user_to_add = User::where('email', $this->searchTerm)->first();
        if ($user_to_add) {
            $this->restaurant->users()->attach($user_to_add->id, ['role' => 'user']);
            $message = 'Registered User: ' . $user_to_add->name . ' ' . $user_to_add->email . ' successfully added.';
        } else {
            $anonymous_user = User::create([
                'email' => $this->searchTerm,
                'name' => $this->searchTerm
            ]);
            $this->restaurant->users()->attach($anonymous_user->id, ['role' => 'anonymous']);
            $message = 'Anonymous User: ' . $user_to_add->email . ' successfully added.';
        }
        $this->emitTo('edit-restaurant', 'userAdded', $message);
        $this->dispatchBrowserEvent('close-add-account');
    }

    public function render()
    {

        if ($this->searchTerm && strlen($this->searchTerm) > 2) {
            $searchTerm = '%' . $this->searchTerm . '%';
            $this->users = User::where('email', 'like', $searchTerm)->get();
        }
        return view('livewire.add-account');
    }
}
