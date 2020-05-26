<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Table;
use App\Restaurant;

class EditTable extends Component
{
    public $table;
    public $restaurant;

    public $seats;
    public $description;
    public $table_number;

    public function getTableUpdatedAtForHumans()
    {
        return $this->table->updated_at->format('Y-m-d H:i:s');
    }

    public function mount(Table $table, Restaurant $restaurant)
    {
        $this->table = $table;
        $this->restaurant = $restaurant;

        $this->seats = $table->seats;
        $this->description = $table->description;
        $this->table_number = $table->table_number;
    }

    public function updated($field, $value)
    {
        $this->validateOnly($field, [
            'table_number' => 'integer',
            'seats' => 'integer',
            'description' => 'string|nullable|max:255'
        ]);

        if ($this->table[$field] != $value) {
            $this->emit('activateSubmit');
        }
    }

    public function submit()
    {
        $this->validate([
            'table_number' => 'integer',
            'seats' => 'integer',
            'description' => 'string|nullable|max:255'
        ]);

        $message = "";
        if ($this->table) {
            $this->table->seats = $this->seats;
            $this->table->description = $this->description;
            $this->table->table_number = $this->table_number;
            if ($this->table->isDirty()) {
                $this->table->save();
                if ($this->table->wasChanged()) {
                    $message = 'Table was successfully updated.';
                } else {
                    $message = 'Something went wrong!';
                }
            } else {
                $message = 'Table has not changed.';
            }
        } else {
            $newTable = Restaurant::find($this->restaurant->id)->tables()->create([
                'seats' => $this->seats,
                'description' => $this->description,
                'table_number' => $this->table_number
            ]);
            if ($newTable) {
                $message = 'Table successfully created';
            } else {
                $message = 'Could not create table. Please contact service team.';
            }
        }
        session()->flash('message', $message);
    }

    public function render()
    {
        return view('livewire.edit-table');
    }
}
