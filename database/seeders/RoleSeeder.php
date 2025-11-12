<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['id' => '38721af0-1743-43bd-b025-0aa074c6e890', 'name' => 'admin']);
        Role::create(['id' => '05895fba-5be5-4eaf-a09c-b5fdfcc0fb94', 'name' => 'student']);
    }
}
