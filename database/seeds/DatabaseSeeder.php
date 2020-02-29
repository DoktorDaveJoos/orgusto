<?php

use App\Reservation;
use App\Restaurant;
use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            UsersTableSeeder::class,
            RestaurantTableSeeder::class,
            TablesTableSeeder::class
        ]);

    }
}
