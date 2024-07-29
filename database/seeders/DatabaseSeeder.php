<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Hash;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RoleSeederTable::class);
        $this->call(UserSeederTable::class);
        // $this->call(CourseSeederTable::class);
    }
}
