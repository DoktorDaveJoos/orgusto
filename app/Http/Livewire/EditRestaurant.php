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
    public $d_seat_count;
    public $seat_bound;
    public $zip_code;
    public $tables;
    public $street;
    public $owner;
    public $name;
    public $city;

    public $is_dirty;

    protected $listeners = ['userAdded' => 'handleUserAdded'];

    public function handleUserAdded($message)
    {
        session()->flash('message', $message);
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

        $this->is_dirty = false;

        $this->restaurant = $restaurant;
        $this->authorize('view', $this->restaurant);

        $this->seat_bound = $restaurant->seat_reservation_bound;
        $this->d_seat_count = $restaurant->default_table_seats;
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
        $isValidated = $this->validateOnly($field, [
            'contact_email' => 'email:rfc|nullable',
            'street' => 'string|nullable|max:255',
            'd_seat_count' => 'integer|required',
            'owner' => 'string|nullable|max:255',
            'city' => 'string|nullable|max:255',
            'seat_bound' => 'boolean|required',
            'street_number' => 'integer',
            'name' => 'string|required',
            'zip_code' => 'integer',
        ]);

        if ($isValidated) {
            $this->is_dirty = $this->restaurant->contact_email != $this->contact_email ||
                $this->restaurant->zip_code != $this->zip_code ||
                $this->restaurant->street != $this->street ||
                $this->restaurant->owner != $this->owner ||
                $this->restaurant->name != $this->name ||
                $this->restaurant->city != $this->city ||
                $this->restaurant->seat_reservation_bound != $this->seat_bound ||
                $this->restaurant->default_table_seats != $this->d_seat_count;
        }
    }

    public function submit()
    {
        $this->authorize('update', $this->restaurant);

        $this->validate([
            'street_number' => 'integer|nullable',
            'street' => 'string|nullable|max:255',
            'd_seat_count' => 'integer|required',
            'owner' => 'string|nullable|max:255',
            'contact_email' => 'email|required',
            'city' => 'string|nullable|max:255',
            'seat_bound' => 'boolean|required',
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
            $this->restaurant->seat_reservation_bound = $this->seat_bound;
            $this->restaurant->default_table_seats = $this->d_seat_count;


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
            $this->restaurant->seat_reservation_bound = $this->seat_bound;
            $this->restaurant->default_table_seats = $this->d_seat_count;
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
            'seats' => $this->d_seat_count,
        ]);

        if ($newTable) {
            session()->flash('message', 'Table with number: ' . $newTable->table_number . ' created');
        } else {
            session()->flash('message', 'Table with number: ' . $newTable->table_number . ' not created. Contact service team.');
        }

        $this->tables = $this->restaurant->tables()->get();
    }

    public function deleteTable($id)
    {
        $this->authorize('delete', $this->restaurant);

        $deleted = Table::destroy($id);
        if ($deleted) {
            session()->flash('message', 'Table deleted');
        } else {
            session()->flash('message', 'Table not deleted. Contact service team.');
        }
        $this->tables = $this->restaurant->tables()->get();
    }

    public function removeAccount($id)
    {
        $this->authorize('update', $this->restaurant);
        $user = User::find($id);
        $this->restaurant->users()->detach($id);
        session()->flash('message', 'User: ' . $user->email . ' successfully detached from restaurant.');
    }

    public function render()
    {
        return view('livewire.edit-restaurant');
    }
}
