<?php

namespace Tests\Feature;

use App\Http\Controllers\UsersController;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;
use Illuminate\Support\Str;

class UserTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;

    private $allowed_request_user;

    private $invalid_request_user;

    /**
     * A basic feature test example.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->allowed_request_user = $this->createUser();
        $this->allowed_request_user->assignRole(Role::ADMINISTRATOR);
        $this->allowed_request_user->givePermissionTo(Permission::USER_PERMISSIONS);

        $this->invalid_request_user = $this->createUser();
        $this->invalid_request_user->givePermissionTo([
            Permission::CAN_VIEW_USERS,
            Permission::CAN_ADD_USERS,
        ]);
    }

    public function test_users_permission_ok()
    {
        $response = $this->actingAs($this->allowed_request_user)
            ->json(Request::METHOD_GET, UsersController::USERS_API_URL);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_users_permission_fail()
    {
        $response = $this->actingAs($this->invalid_request_user)
            ->json(Request::METHOD_GET, UsersController::USERS_API_URL);

        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function test_users_store_user()
    {
        $password = Str::random(6);

        $param = [
            'username' => $this->faker()->userName,
            'email' => $this->faker()->email,
            'password' => $password,
            'password_confirmation' => $password,
            'role' => Role::ADMINISTRATOR
        ];

        $response = $this->actingAs($this->allowed_request_user)
            ->json(Request::METHOD_POST, UsersController::USERS_API_URL, $param);

        $response->assertStatus(Response::HTTP_FOUND);
    }

    public function test_users_change_role()
    {
        $password = Str::random(6);

        $created_param = [
            'username' => $this->faker()->userName,
            'email' => $this->faker()->email,
            'password' => $password,
            'password_confirmation' => $password,
            'role' => Role::ADMINISTRATOR
        ];

        $human_resource_role = [
            'name' => 'human_resource',
            'description' => 'Human Resource'
        ];

        $information_technology_role = [
            'name' => 'information_technology',
            'description' => 'Information Technology'
        ];

        Role::create($human_resource_role);
        Role::create($information_technology_role);

        $user = User::create($created_param);

        $update_param = [
            'username' => $user->username,
            'email' => $user->email,
            'role' => $human_resource_role
        ];

        $url = UsersController::USERS_API_URL . '/' . $user->id;

        $response = $this->actingAs($this->allowed_request_user)
            ->json(Request::METHOD_PUT, $url, $update_param);

        dd($response->json(), $update_param, $user);

        // $response->assertStatus(Response::HTTP_FOUND);
    }
}
