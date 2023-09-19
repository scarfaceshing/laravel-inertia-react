<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminSeeder extends Seeder
{
    private const ADMIN = [
        'name' => "Admin",
        'username' => "admin",
        'email' => 'admin@system.com',
        'password' => '$2y$10$DrEJaCZm7GGWtyvARcVOqOvI7.AbjwB0OUzUX3a7xWGLHNOZFtCzO'
    ];

    public function run()
    {
        /* TODO: Create if not exist to the given data */

        User::factory()->create(self::ADMIN);
    }
}
