<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Role;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Hash;
use App\Models\Permission;

class AccountSeeder extends Seeder
{
    public function run()
    {
        if (App::environment() === 'local')
        {
            // Human Resource

            $employee = Employee::factory()->create();
            $hr_user = $employee->user;

            $hr_user->update([
                'username' => 'hr',
                'email' => 'hr@bredco.com',
                'password' => Hash::make('hr'),
                'is_active' => true
            ]);

            $hr_user->assignRole(Role::HUMAN_RESOURCE);
            $hr_user->givePermissionTo(Permission::ALL_PERMISSIONS_HUMAN_RESOURCE);
        }
    }
}
