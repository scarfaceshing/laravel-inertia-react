<?php

namespace Tests;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\WithFaker;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use WithFaker;

    public function createUser(): User
    {
        return User::factory()->create([
            'is_active' => true
        ]);
    }

    public function createEmployee(): Employee
    {
        return Employee::factory()->create();
    }

    public function getEmployeeMultiplePhoneNumbers(): array
    {
        $array_phone_numbers = [];

        for ($i = 0; $i < mt_rand(0, 10); $i++) {
            array_push($array_phone_numbers, $this->faker->phoneNumber());
        }

        return $array_phone_numbers;
    }
}
