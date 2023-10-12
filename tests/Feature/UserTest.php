<?php

namespace Tests\Feature;

use App\Http\Controllers\UsersController;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Testing\Fluent\AssertableJson;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserTest extends TestCase
{
 use WithFaker;
 use RefreshDatabase;

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
  $this->dummy_user = $this->createUser();
 }

 public function test_users_permission_ok(): void
 {
  $response = $this->actingAs($this->allowed_request_user)
   ->json(Request::METHOD_GET, UsersController::USERS_API_URL);

  $response->assertStatus(Response::HTTP_OK);
 }

 public function test_users_permission_fail(): void
 {
  $response = $this->actingAs($this->invalid_request_user)
   ->json(Request::METHOD_GET, UsersController::USERS_API_URL);

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
  ];

  $response = $this->actingAs($this->allowed_request_user)
   ->json(Request::METHOD_POST, UsersController::USERS_API_URL, $param);

  $response->assertStatus(Response::HTTP_FOUND);
 }

 public function test_users_update_user()
 {
  $password = Str::random(6);

  $param = [
   'username' => $this->faker()->userName,
   'email' => $this->faker()->email,
   'password' => $password,
   'password_confirmation' => $password,
   'is_active' => TRUE,
   'permissions' => Permission::ALL_PERMISSIONS,
  ];

  $response = $this->actingAs($this->allowed_request_user)
   ->json(
    Request::METHOD_PUT,
    UsersController::USERS_API_URL . '/' . $this->dummy_user->id,
    $param
   );

  $response
   ->assertValid(['username', 'email', 'password', 'password_confirmation', 'permissions'])
   ->assertStatus(Response::HTTP_FOUND);

  $this->assertDatabaseHas('users', [
   'id' => $this->dummy_user->id,
   'username' => $param['username'],
   'email' => $param['email'],
   'is_active' => TRUE
  ]);

  $dummy_user_permissions = User::findOrFail($this->dummy_user->id)->permissions;
  $dummy_user_permissions = $dummy_user_permissions->pluck('name')->toArray();

  $this->assertEquals($dummy_user_permissions, Permission::ALL_PERMISSIONS);
 }
}
