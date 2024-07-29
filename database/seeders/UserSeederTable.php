<?php

namespace Database\Seeders;

use App\Models\User;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Admin',
            'email' => 'admin@admin.com',
            'role_id' => 2,
            'password' => Hash::make('password'),
        ]);

        // Create student users
        for ($i = 1; $i <= 19; $i++) {
            User::create([
                'first_name' => fake()->firstName,
                'last_name' => fake()->lastName,
                'email' => fake()->email,
                'role_id' => 1, // student role
                'password' => Hash::make('password'),
            ]);
        }
    }
}
