<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\User;

class EditUser extends Component
{
  public $user;

  public $name;
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
    $this->type = $user->type;
    $this->email = $user->email;

    $this->is_dirty = false;
  }

  public function updated($field, $value)
  {
    $this->validateOnly($field, [
      'name' => 'string',
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
    $message = $this->user->wasChanged() ? __('messages.user_updated') : __('messages.went_wrong');
    session()->flash('message', $message);
  }

  public function render()
  {
    return view('livewire.edit-user');
  }
}
