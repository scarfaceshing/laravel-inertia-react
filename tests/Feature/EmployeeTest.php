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
use Illuminate\Support\Arr;
use Inertia\Testing\AssertableInertia as Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Tests\TestTraits;
use Tests\Utilities\TestStorage;

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
            ->json(Request::METHOD_GET, EmployeeController::URL . "?" . Arr::query($param));

        $response->assertInertia(
            fn (Assert $page) => $page
                ->component('Employees/Index')
                ->has(
                    'data.data',
                    function (Assert $page) use ($employee) {
                        $page->where('0.first_name', $employee->first_name);
                        $page->where('0.middle_name', $employee->middle_name);
                        $page->where('0.last_name', $employee->last_name);
                        $page->where('0.birth_date', $employee->birth_date);
                        $page->where('0.address', $employee->address);
                        $page->where('0.hired_date', $employee->hired_date);
                        $page->where('0.department', $employee->department);
                        $page->where('0.position', $employee->position);
                        $page->where('0.gender', $employee->gender);
                        $page->where('0.civil_status', $employee->civil_status);
                        $page->where('0.employee_status', $employee->employee_status);
                    }
                )
        );
    }

    public function test_store_employee()
    {
        $storage = new TestStorage;
        $image = $storage->generateFakeImage()->resolution();

        $param = [
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->lastName(),
            'last_name' => $this->faker->lastName(),
            'birth_date' => $this->faker->date($format = 'Y-m-d', $max = 'now'),
            'address' => $this->faker->address(),
            'email_address' => $this->faker->email(),
            'hired_date' => $this->faker->date($format = 'Y-m-d', $min = 'now'),
            'employee_status' => $this->faker->randomElement(Constants::EMPLOYEE_STATUS),
            'department' => $this->faker->randomElement(Department::ALL_DEPARTMENTS),
            'position' => $this->faker->randomElement(Position::ALL_POSITIONS),
            'gender' => $this->faker->randomElement(Constants::GENDER),
            'civil_status' => $this->faker->randomElement(Constants::CIVIL_STATUS),
            'phone_number' => $this->getEmployeeMultiplePhoneNumbers()
        ];

        $response = $this->actingAs($this->user)
            ->json(Request::METHOD_POST, EmployeeController::URL, $param)
            ->assertStatus(Response::HTTP_FOUND)
            ->assertRedirect(route('employees.index'));

        $assert_employees = Arr::except($param, ['phone_number', 'email_address']);

        $this->assertDatabaseHas(
            'employees',
            $assert_employees
        );

        $this->assertDatabaseHas(
            'users',
            [
                'email' => $param['email_address'],
                'is_active' => 0,
            ]
        );
    }
}
