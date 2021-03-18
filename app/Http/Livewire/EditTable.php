<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Table;
use App\Restaurant;

class EditTable extends Component
{
    public $table;
    public $restaurant;

    //    public $id;
    public $seats;
    public $description;
    public $table_number;

    public $is_dirty;

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

        $this->is_dirty = false;
    }

    public function updated($field, $value)
    {
        $this->validateOnly($field, [
            'table_number' => 'integer',
            'seats' => 'integer',
            'description' => 'string|nullable|max:255',
        ]);

        $this->is_dirty =
            $this->table->table_number != $this->table_number ||
            $this->table->seats != $this->seats ||
            $this->table->description != $this->description;
    }

    public function submit()
    {
        $validated = $this->validate([
            'table_number' => 'required|integer',
            'seats' => 'required|integer',
            'description' => 'string|nullable|max:255',
        ]);

        $this->table->update($validated);
        $message = $this->table->wasChanged() ? __('messages.table_updated') : __('messages.went_wrong');
        session()->flash('message', $message);
    }

    public function render()
    {
        return view('livewire.edit-table');
    }
}
