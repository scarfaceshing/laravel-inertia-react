<?php

namespace Tests\Feature;

use App\Constants\Constants;
use App\Http\Controllers\EmployeeController;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tests\TestTraits;

class EmployeeTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;
    use TestTraits;

    private $user;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = $this->createUser();
        $this->user->assignRole(Role::HUMAN_RESOURCE);
        $this->user->givePermissionTo(Permission::ALL_PERMISSIONS_HUMAN_RESOURCE);
    }

    public function test_index_employee()
    {

    }

    public function test_store_employee()
    {
        $param = [
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->lastName(),
            'last_name' => $this->faker->lastName(),
            'birth_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'address' => $this->faker->address(),
            'email_address' => $this->faker->email(),
            'hired_date' => $this->faker->date($format = 'Y-m-d', $min = 'now'),
            'regularization' => $this->faker->randomElement(Constants::REGULARIZATION),
            'department' => null,
            'position' => null,
            'gender' => $this->faker->randomElement(Constants::GENDER),
            'civil_status' => $this->faker->randomElement(Constants::CIVIL_STATUS),
            'phone_number' => $this->getEmployeeMultiplePhoneNumbers()
        ];

        $response = $this->actingAs($this->user)
            ->json(Request::METHOD_POST, EmployeeController::URL, $param);

        $response->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseHas(
            'employees',
            [
                ...collect($param)->forget(['phone_number', 'email_address'])->toArray(),
            ]
        );
    }
}
