<?php

namespace App\Http\Livewire;

use App\Restaurant;
use App\Table;
use App\User;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EditRestaurant extends Component
{
    use AuthorizesRequests;

    public $restaurant;

    public $contact_email;
    public $street_number;
    public $zip_code;
    public $tables;
    public $street;
    public $owner;
    public $name;
    public $city;

    protected $listeners = ['userAdded' => 'handleUserAdded'];

    public function handleUserAdded($message)
    {
        session()->flash('account-operations', $message);
    }

    public function getRestaurantUpdatedAtForHumans()
    {
        return $this->restaurant->updated_at->format('Y-m-d H:i:s');
    }

    public function getUsersWithPivot()
    {
        return $this->restaurant->users()->withPivot('role')->get();
    }

    public function mount(Restaurant $restaurant)
    {

        $this->restaurant = $restaurant;
        $this->authorize('view', $this->restaurant);

        $this->contact_email = $restaurant->contact_email;
        $this->street_number = $restaurant->street_number;
        $this->zip_code = $restaurant->zip_code;
        $this->street = $restaurant->street;
        $this->owner = $restaurant->owner;
        $this->name = $restaurant->name;
        $this->city = $restaurant->city;

        $this->tables = $restaurant->tables()->get();
    }

    public function updated($field, $value)
    {
        $this->validateOnly($field, [
            'contact_email' => 'email:rfc|nullable',
            'street' => 'string|nullable|max:255',
            'owner' => 'string|nullable|max:255',
            'city' => 'string|nullable|max:255',
            'street_number' => 'integer',
            'name' => 'string|required',
            'zip_code' => 'integer',
        ]);

        if ($this->restaurant[$field] != $value) {
            $this->emit('activateSubmit');
        }
    }

    public function submit()
    {
        $this->authorize('update', $this->restaurant);

        $this->validate([
            'street_number' => 'integer|nullable',
            'street' => 'string|nullable|max:255',
            'owner' => 'string|nullable|max:255',
            'contact_email' => 'email|required',
            'city' => 'string|nullable|max:255',
            'zip_code' => 'integer|nullable',
            'name' => 'string|required',
        ]);

        $message = "";
        if ($this->restaurant) {
            $this->restaurant->contact_email = $this->contact_email;
            $this->restaurant->zip_code = $this->zip_code;
            $this->restaurant->street = $this->street;
            $this->restaurant->owner = $this->owner;
            $this->restaurant->name = $this->name;
            $this->restaurant->city = $this->city;


            $this->restaurant->save();
            if ($this->restaurant->wasChanged()) {
                $message = 'Restaurant was successfully updated.';
            } else {
                $message = 'Restaurant has not changed!';
            }
        } else {
            $newRestaurant = new Restaurant;
            $newRestaurant->contact_email = $this->contact_email;
            $newRestaurant->zip_code = $this->zip_code;
            $newRestaurant->street = $this->street;
            $newRestaurant->owner = $this->owner;
            $newRestaurant->name = $this->name;
            $newRestaurant->city = $this->city;
            $newRestaurant->save();
            if ($newRestaurant) {
                $message = 'Restaurant successfully created';
            } else {
                $message = 'Could not create Restaurant. Please contact service team.';
            }
        }
        session()->flash('message', $message);
    }

    public function addTable()
    {
        $this->authorize('update', $this->restaurant);

        $max_table_number = $this->tables->max('table_number') + 1;

        $newTable = $this->restaurant->tables()->create([
            'table_number' => $max_table_number,
            'seats' => 4,
        ]);

        if ($newTable) {
            session()->flash('table-operations', 'Table with number: ' . $newTable->table_number . ' created');
        } else {
            session()->flash('table-operations', 'Table with number: ' . $newTable->table_number . ' not created. Contact service team.');
        }

        $this->tables = $this->restaurant->tables()->get();
    }

    public function deleteTable($id)
    {
        $this->authorize('delete', $this->restaurant);

        $deleted = Table::destroy($id);
        if ($deleted) {
            session()->flash('table-operations', 'Table deleted');
        } else {
            session()->flash('table-operations', 'Table not deleted. Contact service team.');
        }
        $this->tables = $this->restaurant->tables()->get();
    }

    public function removeAccount($id)
    {
        $this->authorize('update', $this->restaurant);
        $user = User::find($id);
        $this->restaurant->users()->detach($id);
        session()->flash('account-operations', 'User: ' . $user->email . ' successfully detached from restaurant.');
    }

    public function render()
    {
        return view('livewire.edit-restaurant');
    }
}
