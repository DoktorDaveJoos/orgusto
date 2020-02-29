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
            'access_level' => 'admin',
            'email' => 'joos.code@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('test')
        ]);

        factory(App\User::class, 10)->create();

    }
}
