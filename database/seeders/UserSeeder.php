<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    private const USER = [
        'password' => '$2y$10$DrEJaCZm7GGWtyvARcVOqOvI7.AbjwB0OUzUX3a7xWGLHNOZFtCzO',
    ];

    public function run()
    {
        /* TODO: Create if not exist to the given data */

        User::factory(250)->create(self::USER);
    }
}
