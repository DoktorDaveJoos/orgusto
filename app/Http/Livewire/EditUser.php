<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\User;

class EditUser extends Component
{

    public $user;

    public $name;
    public $access_level;
    public $email;
    public $type;

    public $is_dirty;

    public function getUserUpdatedAtForHumans()
    {
        return $this->user->updated_at->format('Y-m-d H:i:s');
    }

    public function mount(User $user)
    {
        $this->user = $user;

        $this->name = $user->name;
        $this->access_level = $user->access_level;
        $this->type = $user->type;
        $this->email = $user->email;

        $this->is_dirty = false;
    }

    public function updated($field, $value)
    {
        $this->validateOnly($field, [
            'name' => 'string'
        ]);

        $this->is_dirty = $this->user->name != $this->name;
    }

    public function submit()
    {
        $validated = $this->validate([
            'name' => 'required|string',
        ]);

        $this->user->update($validated);
        $this->is_dirty = false;
        $message = $this->user->wasChanged() ? 'User successfully changed' : 'Something went wrong';
        session()->flash('message', $message);
    }

    public function render()
    {
        return view('livewire.edit-user');
    }
}
