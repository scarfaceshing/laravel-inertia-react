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
use Tests\TestTraits;

class UserTest extends TestCase
{
    use WithFaker;
    use RefreshDatabase;
    use TestTraits;

    private $allowed_request_user;

    private $invalid_request_user;

    private $dummy_user;

    /**
     * A basic feature test example.
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->allowed_request_user = $this->createUser();
        $this->allowed_request_user->assignRole(Role::ADMINISTRATOR);
        $this->allowed_request_user->givePermissionTo(Permission::ALL_PERMISSIONS);

        $this->invalid_request_user = $this->createUser();
    }

    public function test_users_permission_ok(): void
    {
        $response = $this->actingAs($this->allowed_request_user)
            ->json(Request::METHOD_GET, UsersController::URL);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_users_permission_fail(): void
    {
        $response = $this->actingAs($this->invalid_request_user)
            ->json(Request::METHOD_GET, UsersController::URL);

        $response->assertStatus(Response::HTTP_INTERNAL_SERVER_ERROR);
    }

    public function test_users_store_user(): void
    {
        $password = Str::random(6);

        $param = [
            'username' => $this->faker()->userName,
            'email' => $this->faker()->email,
            'password' => $password,
            'password_confirmation' => $password,
            'permissions' => Permission::ALL_PERMISSIONS,
            'roles' => $this->faker->randomElement(Role::ALL_ROLES),
            'is_active' => true
        ];

        $response = $this->actingAs($this->allowed_request_user)
            ->json(Request::METHOD_POST, UsersController::URL, $param);

        $this->assertDatabaseHas('users', [
            'username' => $param['username'],
            'email' => $param['email'],
            'is_active' => 1,
        ]);


        $response->assertStatus(Response::HTTP_FOUND);
    }

    public function test_users_update_user()
    {
        $password = Str::random(6);
        $dummy_user = $this->createUser();

        $param = [
            'id' => $dummy_user->id,
            'username' => $this->faker()->userName,
            'email' => $this->faker()->email,
            'password' => $password,
            'password_confirmation' => $password,
            'permissions' => Permission::ALL_PERMISSIONS,
            'is_active' => false,
        ];

        $response = $this->actingAs($this->allowed_request_user)
            ->json(
                Request::METHOD_PUT,
                UsersController::URL . '/' . $dummy_user->id,
                $param
            );

        $response
            ->assertValid(['username', 'email', 'password', 'password_confirmation', 'permissions', 'is_active'])
            ->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseHas('users', [
            'id' => $dummy_user->id,
            'username' => $param['username'],
            'email' => $param['email'],
            'is_active' => 0,
        ]);

        $dummy_user_permissions = User::findOrFail($dummy_user->id)->permissions;
        $dummy_user_permissions = $dummy_user_permissions->pluck('name')->toArray();

        $this->assertEquals($dummy_user_permissions, Permission::ALL_PERMISSIONS);
    }

    public function test_users_non_dirty_update()
    {
        $dummy_user = $this->createUser();

        $param = [
            'id' => $dummy_user->id,
            'username' => $dummy_user->username,
            'email' => $dummy_user->email,
            'password' => null,
            'password_confirmation' => null,
            'is_active' => false,
            'permissions' => [],
        ];

        $response = $this->actingAs($this->allowed_request_user)
            ->json(
                Request::METHOD_PUT,
                UsersController::URL . '/' . $dummy_user->id,
                $param
            );

        $response
            ->assertValid(['username', 'email', 'password', 'password_confirmation', 'permissions', 'is_active'])
            ->assertStatus(Response::HTTP_FOUND);

        $this->assertDatabaseHas('users', [
            'id' => $dummy_user->id,
            'username' => $param['username'],
            'is_active' => $param['is_active'],
            'email' => $param['email'],
        ]);

        $dummy_user_permissions = User::findOrFail($dummy_user->id)->permissions;
        $dummy_user_permissions = $dummy_user_permissions->pluck('name')->toArray();

        $this->assertEquals($dummy_user_permissions, []);
    }

    public function test_users_delete()
    {
        $dummy_user = $this->createUser();

        $response = $this->actingAs($this->allowed_request_user)
            ->json(
                Request::METHOD_DELETE,
                UsersController::URL . '/' . $dummy_user->id,
            );

        $response->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseMissing('users', [
            'id' => $dummy_user->id,
            'username' => $dummy_user->username,
            'is_active' => $dummy_user->is_active,
            'email' => $dummy_user->email,
        ]);
    }
}
