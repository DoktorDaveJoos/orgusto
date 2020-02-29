<?php

use Illuminate\Database\Seeder;

class TablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Table::class, 10)->create()->each(function($table) {
            $reservations = factory(App\Reservation::class, 2)->make();
            $table->reservations()->saveMany($reservations);
        });
    }
}
