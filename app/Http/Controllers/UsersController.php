<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\ACL\ACL;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use App\Models\Permission;

class UsersController extends Controller
{
 public const USERS_API_URL = '/users';

 public function index(Request $request)
 {
  ACL::allowOnly([Permission::CAN_VIEW_USERS]);

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
   'data' => $data
  ]);
 }

 public function create()
 {
  return Inertia::render('Users/Create');
 }

 public function store(UserRequest $request)
 {
  $data = $request->only('username', 'email', 'password', 'is_active', 'permissions');
  $data['password'] = Hash::make($data['password']);

  User::create($data)->givePermissionTo($data['permissions']);

  return to_route('users.index');
 }

 public function edit(User $user)
 {
  return Inertia::render('Users/Edit', [
   'users' => $user->only('id', 'username', 'email', 'is_active'),
   'permissions' => $user->permissions->pluck('name'),
   'roles' => $user->roles->pluck('name')
  ]);
 }

 public function update(User $user, UserRequest $request)
 {
  if ($request->password) {
   $user->update($request->only('username', 'email', 'password'));
  } else {
   $user->update($request->only('username', 'email'));
  }

  // TODO: array_unique should be in front end
  $user->syncPermissions(array_unique($request->permissions));

  return to_route('users.index');
 }

 public function destroy(User $user)
 {
  User::findOrFail($user->id)->delete();
 }
}
