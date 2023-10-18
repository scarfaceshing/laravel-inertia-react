<?php

namespace Database\Factories;

use App\Constants\Constants;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

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
        $employee_number = strtoupper($this->faker->shuffle(
            $this->faker->randomNumber($nbDigits = null, $strict = false).Str::random(5)
        ));

        return [
            'employee_number' => $employee_number,
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->lastName(),
            'last_name' => $this->faker->lastName(),
            'birth_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'hired_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'regularization' => $this->faker->randomElement(Constants::REGULARIZATION),
            'department' => null,
            'position' => null,
            'sex' => $this->faker->randomElement(Constants::SEX),
            'civil_status' => $this->faker->randomElement(Constants::CIVIL_STATUS),
            'deleted_at' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'is_active' => $this->faker->randomElement([true, false]),
        ];
    }
}
