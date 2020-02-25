<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'David Joos',
            'id' => 1,
            'email' => 'joos.code@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('test'),
            'restaurants' => '[1]'
        ]);

        factory(App\User::class, 50)->create();

    }
}
