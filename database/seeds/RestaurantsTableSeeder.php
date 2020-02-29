<?php

use App\Restaurant;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RestaurantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::first();
        $user->restaurants()->save(
            Restaurant::create(['name' => 'Amboss']),
            ['role' => 'admin']
        );

    }
}
