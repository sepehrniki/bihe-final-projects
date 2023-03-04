<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'firstname' => 'main',
            'lastname' => 'admin',
            'username' => 'admin',
            'type' => 1,
            'password' => Hash::make('Admin123!@#'),
        ]);
    }
}
