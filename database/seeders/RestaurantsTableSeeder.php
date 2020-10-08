<?php
namespace Database\Seeders;

use App\Restaurant;
use App\User;
use Illuminate\Database\Seeder;

class RestaurantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Restaurant::factory()->count(5)->create();
    }
}
