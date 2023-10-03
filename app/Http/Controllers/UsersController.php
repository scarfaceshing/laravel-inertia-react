<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use App\Utilities\Middleware;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UsersController extends Controller
{
 public const USERS_API_URL = '/users';

 public function __construct()
 {
  $permissions = ['can_view_users', 'can_add_users', 'can_edit_users', 'can_delete_users'];
  $permissions = Middleware::extractPermissions('allowOnly', $permissions);
  $this->middleware($permissions);
 }

 public function index(Request $request)
 {
  $limit = $request->query('limit');
  $search = $request->query('search');
  $sort_by = $request->query('sortBy');
  $order_by = $request->query('orderBy');

  $users = User::where('username', 'LIKE', "%{$search}%")
   ->orWhere('email', 'LIKE', "%{$search}%")
   ->when($sort_by, fn ($query) => $query->orderBy($sort_by, $order_by))
   ->paginate($limit);

  return Inertia::render('Users/Index', [
      'users' => $users,
  ]);
 }

 public function create()
 {
  return Inertia::render('Users/Create');
 }

 public function store(UserRequest $request)
 {
  User::create($request->all());

  return to_route('users.index');
 }

 public function edit(User $user)
 {
  return Inertia::render('Users/Edit', [
      'users' => $user->only('id', 'username', 'email'),
  ]);
 }

 public function update(User $user, UserRequest $request)
 {
  if ($request->password) {
   $user->update($request->only('username', 'email', 'password'));
  } else {
   $user->update($request->only('username', 'email'));
  }

  return to_route('users.index');
 }

 public function destroy(User $user)
 {
  User::findOrFail($user->id)->delete();
 }
}
