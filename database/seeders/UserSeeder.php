<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@sipemas.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        // Create Staf Desa User
        User::create([
            'name' => 'Staf Desa',
            'email' => 'staf@sipemas.com',
            'password' => bcrypt('password'),
            'role' => 'staf_desa',
        ]);

        // Create Perwakilan Masyarakat User
        User::create([
            'name' => 'Warga Masyarakat',
            'email' => 'warga@sipemas.com',
            'password' => bcrypt('password'),
            'role' => 'perwakilan_masyarakat',
        ]);
    }
}
