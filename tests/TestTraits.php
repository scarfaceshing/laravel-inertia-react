<?php

namespace Tests;

use Illuminate\Testing\TestResponse;
use App\Models\Employee;
use App\Models\User;

trait TestTraits
{
    public function responseDd(TestResponse $response): void
    {
        $get_only_response = collect($response->json());
        $trace = $get_only_response['trace'][0];

        $new_response = collect([
            ...$get_only_response->forget('trace'),
            'trace' => $trace
        ]);

        $new_response->dd();
    }

    public function responseDump(TestResponse $response): void
    {
        $get_only_response = collect($response->json());
        $trace = $get_only_response['trace'][0];

        $new_response = collect([
            ...$get_only_response->forget('trace'),
            'trace' => $trace
        ]);

        $new_response->dump();
    }

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
