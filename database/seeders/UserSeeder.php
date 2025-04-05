<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create some sample users
        $users = [
            [
                'name' => 'User One',
                'email' => 'user1@gmail.com',
                'password' => Hash::make('password'),
                'phone' => '0812345678',
                'role' => 'user'
            ],
            [
                'name' => 'User Two',
                'email' => 'user2@gmail.com',
                'password' => Hash::make('password'),
                'phone' => '0823456789',
                'role' => 'user'
            ]
        ];
        
        foreach ($users as $user) {
            User::create($user);
        }
    }
}