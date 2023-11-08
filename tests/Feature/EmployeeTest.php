<?php

namespace Tests\Feature;

use App\Constants\Constants;
use App\Http\Controllers\EmployeeController;
use App\Models\Department;
use App\Models\Permission;
use App\Models\Position;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tests\TestTraits;
use Illuminate\Support\Facades\Storage;
use Inertia\Testing\AssertableInertia as Assert;

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
        $employee = $this->createEmployee();

        $param = [
            "search" => "",
            "sortBy" => "created_at",
            "orderBy" => "ASC",
            "page" => 1,
            "limit" => 10
        ];

        $response = $this->actingAs($this->user)
            ->json(Request::METHOD_GET, EmployeeController::URL)
                ->assertInertia(fn (Assert $page) => $page
                    ->component('Employees/Index')
                    ->has('data.data', fn (Assert $page) =>
                        $page->where('0.first_name', $employee->first_name)
                )
            );       
    }

    // public function test_store_employee()
    // {
    //     $param = [
    //         'first_name' => $this->faker->firstName(),
    //         'middle_name' => $this->faker->lastName(),
    //         'last_name' => $this->faker->lastName(),
    //         'birth_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
    //         'address' => $this->faker->address(),
    //         'email_address' => $this->faker->email(),
    //         'hired_date' => $this->faker->date($format = 'Y-m-d', $min = 'now'),
    //         'employee_status' => $this->faker->randomElement(Constants::EMPLOYEE_STATUS),
    //         'department' => $this->faker->randomElement(Department::ALL_DEPARTMENTS),
    //         'position' => $this->faker->randomElement(Position::ALL_POSITIONS),
    //         'gender' => $this->faker->randomElement(Constants::GENDER),
    //         'civil_status' => $this->faker->randomElement(Constants::CIVIL_STATUS),
    //         'phone_number' => $this->getEmployeeMultiplePhoneNumbers()
    //     ];

    //     $response = $this->actingAs($this->user)
    //         ->json(Request::METHOD_POST, EmployeeController::URL, $param);

    //     $response->assertInertia(fn (Assert $page) => $page
    //         ->component('Employees/Index')
    //             ->toArray()
    //     );

    //     dd($response);

    //     $this->assertDatabaseHas(
    //         'employees',
    //         [
    //             ...collect($param)->forget(['phone_number', 'email_address'])->toArray(),
    //         ]
    //     );
    // }
}
