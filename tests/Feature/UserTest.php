<?php

namespace Tests\Feature;

use App\Http\Controllers\UsersController;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class UserTest extends TestCase
{
 use RefreshDatabase;

 private $allowed_request_user;

 private $invalid_request_user;

 /**
  * A basic feature test example.
  */
 public function setUp(): void
 {
  parent::setUp();

  $this->allowed_request_user = User::factory()->create();
  $this->allowed_request_user->assignRole(Role::ADMINISTRATOR);
  $this->allowed_request_user->givePermissionTo(Permission::USER_PERMISSIONS);

  $this->invalid_request_user = User::factory()->create();
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
}
