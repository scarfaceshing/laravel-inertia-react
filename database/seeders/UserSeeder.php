<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    private const USER = [
        'password' => '$2y$10$DrEJaCZm7GGWtyvARcVOqOvI7.AbjwB0OUzUX3a7xWGLHNOZFtCzO'
    ];

    public function run()
    {
        /* TODO: Create if not exist to the given data */

        User::factory(250)->create(self::USER);
    }
}
