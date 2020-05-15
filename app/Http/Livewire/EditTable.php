<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Table;
use App\Restaurant;

class EditTable extends Component
{
    public $table;
    public $restaurant;


    public $number;
    public $seats;
    public $description;

    protected $casts = [
        'updated_at' => 'date'
    ];

    public function getUpdatedAtForHumans()
    {
        return $this->updated_at->format('Y-m-d H:i:s');
    }

    public function mount(Table $table, Restaurant $restaurant)
    {
        $this->table = $table;
        $this->restaurant = $restaurant;

        $this->table_number = $table->table_number;
        $this->seats = $table->seats;
        $this->description = $table->description;
    }

    public function submit()
    {
        $this->validate([
            'number' => 'required',
            'seats' => 'required',
            'description' => 'max:255',
        ]);

        if ($this->table_id) {
            $table = Table::find($this->table_id);
            $table->table_number = $this->number;
            $table->seats = $this->seats;
            $table->description = $this->description;
            if ($table->isDirty()) {
                $table->save();

                if ($table->wasChanged()) {
                    session()->flash('message', 'Table was successfully updated.');
                }
            }
        } else {
            Restaurant::find($this->restaurant_id)->tables()->create([
                'table_number' => $this->number,
                'seats' => $this->seats,
                'description' => $this->description
            ]);
        }
    }

    public function render()
    {
        return view('livewire.edit-table');
    }
}
