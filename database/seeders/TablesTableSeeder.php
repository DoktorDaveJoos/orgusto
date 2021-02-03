<?php
namespace Database\Seeders;
use App\Reservation;
use App\Table;
use Database\Factories\ReservationFactory;
use Database\Factories\TableFactory;
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
        Table::factory()->count(10)->has(
            Reservation::factory()->count(10)
        )->create();
    }
}
