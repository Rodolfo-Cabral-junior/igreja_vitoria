<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::create([
            'name' => 'Rodolfo',
            'username' => 'admin',
            'email' => 'rodolfocabra4@gmail.com',
            'role' => 'admin',
            'password' => Hash::make('123456'),
        ]);
    }
}
