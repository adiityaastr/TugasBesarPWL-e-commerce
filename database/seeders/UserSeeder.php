<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin Account
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        // Customer Account
        User::create([
            'name' => 'Customer User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);
        
        echo "Users seeded successfully.\n";
        echo "Admin: admin@example.com | password\n";
        echo "User:  user@example.com  | password\n";
    }
}
