<?php

namespace Database\Factories;

use App\Constants\Constants;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $id_number = strtoupper($this->faker->shuffle(
            $this->faker->randomNumber($nbDigits = null, $strict = false).Str::random(5)
        ));

        return [
            'id_number' => $id_number,
            'user_id' => User::factory(),
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->lastName(),
            'last_name' => $this->faker->lastName(),
            'birth_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'address' => $this->faker->address(),
            'hired_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'employee_status' => $this->faker->randomElement(Constants::EMPLOYEE_STATUS),
            'department' => null,
            'position' => null,
            'gender' => $this->faker->randomElement(Constants::GENDER),
            'civil_status' => $this->faker->randomElement(Constants::CIVIL_STATUS),
            'deleted_at' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
        ];
    }
}
