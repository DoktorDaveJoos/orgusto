<?php

use Illuminate\Database\Seeder;

class RestaurantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('restaurants')->insert([
            'name' => 'Amboss',
            'user_id' => 1,
            'employees' => '["Felix Forstenhäusler", "David Joos"]'
        ]);
    }
}
