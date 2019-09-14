<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::create([
            'name' => 'khoa',
            'email' => 'abc@gmail.com',
            'username' => 'khoa',
            'password' => bcrypt('1234')
        ]);
    }
}
