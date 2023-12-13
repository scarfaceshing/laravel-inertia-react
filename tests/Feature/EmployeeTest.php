<?php

namespace Tests\Feature;

use App\Constants\Constants;
use App\Http\Controllers\EmployeeController;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Image;
use App\Models\Permission;
use App\Models\Position;
use App\Models\Role;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
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

    public function test_index_employee(): void
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

    public function test_store_employee(): void
    {
        $file_name = Str::random(10);
        $extension = $this->faker->randomElement(['jpeg', 'bmp', 'png']);
        $image = TestStorage::generateFakeImage($file_name, $extension, 640, 320, 1024);

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
            'phone_number' => $this->getEmployeeMultiplePhoneNumbers(),
            'photo' => $image,
        ];

        $responseData = [];

        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->json(Request::METHOD_POST, EmployeeController::URL, $param)
            ->assertStatus(Response::HTTP_OK)
            ->assertInertia(
                function (Assert $page) use (&$responseData) {
                    $page->component('Employees/Index');
                    $page->has('data.data', 1);

                    $responseData['props'] = $page->toArray()['props']['data']['data'];
                }
            );

        $responseData['image'] = Image::where('imageable_id', $responseData['props'][0]['id'])->first()->toArray();

        $assert_employees = Arr::except($param, ['phone_number', 'email_address', 'photo']);

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

        $this->assertDatabaseHas(
            'images',
            [
                'file_name' => $responseData['image']['file_name'],
                'path' => $responseData['image']['path'],
                'extension' => $responseData['image']['extension'],
                'imageable_type' => Employee::class,
                'imageable_id' => $responseData['props'][0]['id'],
                'is_primary' => 0
            ]
        );

        $employee_photo_file_path = storage_path('app/images/' . $responseData['image']['path']);

        $this->assertFileExists($employee_photo_file_path);

        if (File::exists($employee_photo_file_path)) {
            File::delete([$employee_photo_file_path]);
        } else {
            dd('File does not exist.');
        }
    }

    public function test_show_and_edit_employee(): void
    {
        $props = [];
        $employee = $this->createEmployee();

        $this->actingAs($this->user)
            ->json(Request::METHOD_GET, EmployeeController::URL . '/' . $employee->id)
            ->assertStatus(Response::HTTP_OK)
            ->assertInertia(
                function (Assert $page) use (&$props) {
                    $page->component('Employees/Show');
                    $page->has('data');
                    $props = $page->toArray()['props']['data'];
                }
            );

        $props = Arr::except($props, ['deleted_at']);
        $assert_employees = Arr::except($employee->toArray(), ['deleted_at']);

        $this->assertEquals(
            $props,
            $assert_employees
        );

        $props = [];
        $employee = $this->createEmployee();

        $this->actingAs($this->user)
            ->json(Request::METHOD_GET, EmployeeController::URL . '/' . $employee->id . '/edit')
            ->assertStatus(Response::HTTP_OK)
            ->assertInertia(
                function (Assert $page) use (&$props) {
                    $page->component('Employees/Edit');
                    $page->has('data');
                    $props = $page->toArray()['props']['data'];
                }
            );

        $props = Arr::except($props, ['deleted_at']);
        $assert_employees = Arr::except($employee->toArray(), ['deleted_at']);

        $this->assertEquals(
            $props,
            $assert_employees
        );
    }

    public function test_update_employee(): void
    {
        $employee = $this->createEmployee();
        $file_name = Str::random(10);
        $extension = $this->faker->randomElement(['jpeg', 'bmp', 'png']);
        $image = TestStorage::generateFakeImage($file_name, $extension, 640, 320, 1024);

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
            'phone_number' => $this->getEmployeeMultiplePhoneNumbers(),
            'photo' => $image,
        ];

        $responseData = [];

        $response = $this->actingAs($this->user)
            ->followingRedirects()
            ->json(Request::METHOD_PUT, EmployeeController::URL . '/' . $employee->id, $param)
            ->assertStatus(Response::HTTP_OK)
            ->assertInertia(
                function (Assert $page) use (&$responseData, $employee, $param) {
                    $page->component('Employees/Index');
                    $page->has('data.data', function (Assert $page) use ($employee, $param) {
                        $param = (object) $param;

                        $page->where('0.first_name', $param->first_name);
                        $page->where('0.middle_name', $param->middle_name);
                        $page->where('0.last_name', $param->last_name);
                        $page->where('0.birth_date', $param->birth_date);
                        $page->where('0.address', $param->address);
                        $page->where('0.hired_date', $param->hired_date);
                        $page->where('0.department', $param->department);
                        $page->where('0.position', $param->position);
                        $page->where('0.gender', $param->gender);
                        $page->where('0.civil_status', $param->civil_status);
                        $page->where('0.employee_status', $param->employee_status);
                    });

                    $responseData['props'] = $page->toArray()['props']['data']['data'];
                }
            );
        
        $this->assertDatabaseMissing(
            'employees',
            [
                'id' => $employee->id,
                'first_name' => $employee->first_name,
                'middle_name' => $employee->middle_name,
                'last_name' => $employee->last_name,
                'gender' => $employee->gender,
                'address' => $employee->address,
                'hired_date' => $employee->hired_date,
                'birth_date' => $employee->birth_date,
                'department' => $employee->department,
                'position' => $employee->position,
                'civil_status' => $employee->civil_status,
                'employee_status' => $employee->employee_status,
            ]
        );

        $param = (object) $param;

        $this->assertDatabaseHas(
            'employees',
            [
                'id' => $employee->id,
                'first_name' => $param->first_name,
                'middle_name' => $param->middle_name,
                'last_name' => $param->last_name,
                'gender' => $param->gender,
                'address' => $param->address,
                'hired_date' => $param->hired_date,
                'birth_date' => $param->birth_date,
                'department' => $param->department,
                'position' => $param->position,
                'civil_status' => $param->civil_status,
                'employee_status' => $param->employee_status,
            ]
        );
    }
}
