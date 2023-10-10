<?php

namespace Tests\Feature;

use App\Http\Controllers\UsersController;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

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
            'role' => Role::ADMINISTRATOR,
        ];

        $response = $this->actingAs($this->allowed_request_user)
            ->json(Request::METHOD_POST, UsersController::USERS_API_URL, $param);

        $response->assertStatus(Response::HTTP_FOUND);
    }
}
