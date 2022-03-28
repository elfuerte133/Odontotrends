<?php

use App\User;
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
        User::create([
            'name' => 'Joel Orlando Urbina Novoa',
            'email' => 'joelurbinanovoa@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('urbinanovoa'), // password
            'dni' => '72788903',
            'address' => '',
            'phone' => '',
            'role' => 'admin'
        ]);
        factory(User::class, 50)->create();

    }
}
