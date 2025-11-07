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
        User::create([
            'id' => 'eb858eb6-6eb2-4256-9db5-455d5ee24ea1',
            'name' => 'Admin User',
            'email' => 'example@example.com',
            'password' => bcrypt('password'),
            'role_id' => '38721af0-1743-43bd-b025-0aa074c6e890',
        ]);
    }
}
