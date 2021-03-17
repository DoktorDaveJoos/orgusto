<?php

namespace Database\Seeders;

use App\Reservation;
use App\Restaurant;
use App\Table;
use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * As well as run the baseUser seed -> for local testing
     *
     * @return void
     */
    public function run()
    {
        $baseUser = [
            'id' => 1,
            'name' => 'David Joos',
            'type' => 'registered',
            'selected_restaurant' => 1,
            'email_verified_at' => now(),
            'password' => bcrypt('test'),
            'email' => 'joos.code@gmail.com',
        ];

        $baseRestaurant = [
            'id' => 1,
            'name' => 'Amboss',
            'owner_id' => 1,
        ];

        // Create local test setup with login for baseUser and Restaurant "Amboss"
        User::factory()
            ->hasAttached(
                Restaurant::factory()
                    ->state($baseRestaurant)
                    ->has(Table::factory()->count(10)),
                ['role' => 'admin']
            )
            ->create($baseUser);

        // Create random users
        User::factory()
            ->count(10)
            ->create();
    }
}
