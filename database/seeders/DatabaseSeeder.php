<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
     if (!User::find(1)) {
        User::create([
            'id'       => 1,
            'name'     => 'Admin',
            'email'    => 'admin@elfarida.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
