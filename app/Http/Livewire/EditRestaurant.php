<?php

namespace App\Http\Livewire;

use App\Restaurant;
use App\Table;
use App\User;
use App\Reservation;
use Livewire\Component;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class EditRestaurant extends Component
{
    use AuthorizesRequests;

    public $restaurant;

    public $contact_email;
    public $street_number;
    public $default_table_seats;
    public $seat_reservation_bound;
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
        return $this->restaurant
            ->users()
            ->withPivot('role')
            ->get();
    }

    public function mount(Restaurant $restaurant)
    {
        $this->is_dirty = false;

        $this->restaurant = $restaurant;
        $this->authorize('view', $this->restaurant);

        $this->seat_reservation_bound = $restaurant->seat_reservation_bound;
        $this->default_table_seats = $restaurant->default_table_seats;
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
            'seat_reservation_bound' => 'boolean',
            'default_table_seats' => 'integer',
            'contact_email' => 'email:rfc',
            'street' => 'string|max:255',
            'street_number' => 'integer',
            'owner' => 'string|max:255',
            'name' => 'string|max:255',
            'city' => 'string|max:255',
            'zip_code' => 'string',
        ]);

        if ($isValidated) {
            $this->is_dirty =
                $this->restaurant->contact_email != $this->contact_email ||
                $this->restaurant->zip_code != $this->zip_code ||
                $this->restaurant->street != $this->street ||
                $this->restaurant->owner != $this->owner ||
                $this->restaurant->name != $this->name ||
                $this->restaurant->city != $this->city ||
                $this->restaurant->seat_reservation_bound != $this->seat_reservation_bound ||
                $this->restaurant->default_table_seats != $this->default_table_seats;
        }
    }

    public function submit()
    {
        $this->authorize('update', $this->restaurant);

        $validated = $this->validate([
            'default_table_seats' => 'required|integer',
            'seat_reservation_bound' => 'boolean',
            'street' => 'nullable|string|max:255',
            'street_number' => 'nullable|integer',
            'owner' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'city' => 'nullable|string|max:255',
            'zip_code' => 'nullable|integer',
            'contact_email' => 'email:rfc',
        ]);

        $this->restaurant->update($validated);
        $this->is_dirty = false;
        $message = $this->restaurant->wasChanged() ? __('messages.updated_restaurant') : __('messages.went_wrong');

        session()->flash('message', $message);
    }

    public function addTable()
    {
        $this->authorize('update', $this->restaurant);

        $max_table_number = $this->tables->max('table_number') + 1;

        if ($this->restaurant->subscribed()) {
            // TODO fix that shit
            if ($this->restaurant->tables->count() > 100) {
                session()->flash('message', 'Du hast die maximale Anzahl an Tischen für diesen Plan erreicht.');
            } else {
                $newTable = $this->restaurant->tables()->create([
                    'table_number' => $max_table_number,
                    'seats' => $this->default_table_seats,
                ]);
                session()->flash('message', __('messages.table_created', ['table_number' => $newTable->table_number]));
            }
        } else {
            session()->flash(
                'message',
                'Bevor du Tische hinzufügst musst Du dich zuerst für einen Plan entscheiden :-).'
            );
        }
        $this->tables = $this->restaurant->tables()->get();
    }

    public function deleteTable($id)
    {
        $this->authorize('delete', $this->restaurant);

        $deleted = Table::destroy($id);
        if ($deleted) {
            session()->flash('message', __('messages.table_deleted'));
        } else {
            session()->flash('message', __('messages.table_not_deleted'));
        }
        $this->tables = $this->restaurant->tables()->get();
    }

    public function removeAccount($id)
    {
        $this->authorize('update', $this->restaurant);
        $user = User::find($id);
        $this->restaurant->users()->detach($id);
        session()->flash('message', __('messages.user_detached', ['email' => $user->email]));
    }

    public function render()
    {
        return view('livewire.edit-restaurant');
    }
}
