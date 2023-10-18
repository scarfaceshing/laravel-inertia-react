<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\ACL\ACL;
use App\Http\Requests\UserRequest;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;

class UsersController extends Controller
{
 public const USERS_API_URL = '/users';

 public function index(Request $request)
 {
  ACL::allowOnly([Permission::CAN_ACCESS_INDEX_USERS]);

  $limit = $request->query('limit');
  $search = $request->query('search');
  $sort_by = $request->query('sortBy');
  $order_by = $request->query('orderBy');

  $data = User::with(['permissions:id,name', 'roles:id,name'])
   ->where('users.username', 'LIKE', "%{$search}%")
   ->orWhere('users.email', 'LIKE', "%{$search}%")
   ->when($sort_by, fn ($query) => $query->orderBy($sort_by, $order_by))
   ->paginate($limit);

  return Inertia::render('Users/Index', [
      'data' => $data,
  ]);
 }

 public function create()
 {
  ACL::allowOnly([Permission::CAN_ACCESS_CREATE_USERS, Permission::CAN_CHANGE_PERMISSIONS_USERS, Permission::CAN_CHANGE_ROLE_USERS]);

  return Inertia::render('Users/Create');
 }

 public function store(UserRequest $request)
 {
  ACL::allowOnly([Permission::CAN_STORE_USER, Permission::CAN_CHANGE_PERMISSIONS_USERS, Permission::CAN_CHANGE_ROLE_USERS]);

  $data = $request->only('username', 'email', 'password', 'is_active', 'permissions', 'roles');
  $data['password'] = Hash::make($data['password']);

  $user = User::create($data);
  $user->givePermissionTo(array_unique($data['permissions']));
  $user->assignRole(array_unique($data['roles']));

  return to_route('users.index');
 }

 public function edit(User $user)
 {
  ACL::allowOnly([Permission::CAN_ACCESS_EDIT_USERS, Permission::CAN_CHANGE_PERMISSIONS_USERS, Permission::CAN_CHANGE_ROLE_USERS]);

  return Inertia::render('Users/Edit', [
      'users' => $user->only('username', 'email', 'is_active'),
      'permissions' => $user->permissions->pluck('name'),
      'roles' => $user->roles->pluck('name'),
  ]);
 }

 public function update(User $user, UserRequest $request)
 {
  ACL::allowOnly([Permission::CAN_UPDATE_USER, Permission::CAN_CHANGE_PERMISSIONS_USERS, Permission::CAN_CHANGE_ROLE_USERS]);

  if ($request->password) {
   $user->update($request->only('username', 'email', 'password'));
  } else {
   $user->update($request->only('username', 'email'));
  }

  // TODO: array_unique should be in front end
  $user->syncPermissions(array_unique($request->permissions));
  $user->syncRoles(array_unique($request->roles));

  return to_route('users.index');
 }

 public function destroy(User $user)
 {
  ACL::allowOnly([Permission::CAN_DELETE_USERS]);

  User::findOrFail($user->id)->delete();
 }
}
