<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('users')->delete();

        $role = [
            'admin'  => 1,
            'reader' => 2,
            'author' => 3,
        ];


        User::create([
            'name'     => 'Admin',
            'email'    => 'admin@bookstore.com',
            'password' => \Hash::make('123456789'),
            'role_id'  => $role['admin']
        ]);
        User::create([
            'name'              => 'Reader',
            'email'             => 'reader@bookstore.com',
            'password'          => \Hash::make('123456789'),
            'account_balance'   => 1000,
            'role_id'           => $role['reader']
        ]);
        User::create([
            'name'     => 'Author',
            'email'    => 'author@bookstore.com',
            'password' => \Hash::make('123456789'),
            'role_id'  => $role['author']
        ]);


        //User Fakers
        User::factory(15)->create();
    }
}
