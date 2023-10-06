<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
 private const USER = [
  'password' => '$2y$10$DrEJaCZm7GGWtyvARcVOqOvI7.AbjwB0OUzUX3a7xWGLHNOZFtCzO',
 ];

 public function run()
 {

  $faker = Faker::create();
  /* TODO: Create if not exist to the given data */

  $user = User::factory()->create(self::USER);
  $role =  $faker->randomElement(ROLE::ALL_ROLES);
  $user->assignRole($role);
 }
}
