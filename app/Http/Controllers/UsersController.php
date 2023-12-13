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
    public const URL = '/users';

    public function index(Request $request)
    {
        ACL::allowOnly([Permission::CAN_ACCESS_INDEX_USERS]);

        $limit = $request->query('limit', 10); // Set a default limit
        $search = $request->query('search');
        $sort_by = $request->query('sortBy');
        $order_by = $request->query('orderBy');

        $data = User::select('users.id', 'users.username', 'users.email') // Specify the columns you want
            ->where(function ($query) use ($search) {
                $query->where('username', 'LIKE', "%$search%")
                    ->orWhere('email', 'LIKE', "%$search%");
            })
            ->when($sort_by, function ($query) use ($sort_by, $order_by) {
                $query->orderBy($sort_by, $order_by);
            })
            ->paginate($limit);

        return Inertia::render('Users/Index', [
            'data' => $data,
        ]);
    }

    public function create()
    {
        ACL::allowOnly([
            Permission::CAN_ACCESS_CREATE_USERS,
            Permission::CAN_CHANGE_PERMISSIONS_USERS,
            Permission::CAN_CHANGE_ROLE_USERS
        ]);

        return Inertia::render('Users/Create');
    }

    public function store(UserRequest $request)
    {
        ACL::allowOnly([
            Permission::CAN_STORE_USERS,
            Permission::CAN_CHANGE_PERMISSIONS_USERS,
            Permission::CAN_CHANGE_ROLE_USERS
        ]);

        $data = $request->only('username', 'email', 'password', 'is_active', 'permissions', 'roles', 'is_active');
        $data['password'] = Hash::make($data['password']);

        $user = User::create($data);
        $user->givePermissionTo($data['permissions']);
        $user->assignRole($data['roles']);

        return redirect()->route('users.index')->with('message', 'Added Successfully');
    }

    public function edit(User $user)
    {
        ACL::allowOnly([
            Permission::CAN_ACCESS_EDIT_USERS,
            Permission::CAN_CHANGE_PERMISSIONS_USERS,
            Permission::CAN_CHANGE_ROLE_USERS
        ]);

        return Inertia::render('Users/Edit', [
            'users' => $user->only('username', 'email', 'is_active'),
            'permissions' => $user->permissions->pluck('name'),
            'roles' => $user->roles->pluck('name'),
        ]);
    }

    public function update(User $user, UserRequest $request)
    {
        ACL::allowOnly([
            Permission::CAN_UPDATE_USERS,
            Permission::CAN_CHANGE_PERMISSIONS_USERS,
            Permission::CAN_CHANGE_ROLE_USERS
        ]);

        if ($request->password) {
            $user->update($request->only('username', 'email', 'password', 'is_active'));
        } else {
            $user->update($request->only('username', 'email', 'is_active'));
        }

        // TODO: array_unique should be in front end
        $user->syncPermissions($request->permissions);
        $user->syncRoles($request->roles);

        return to_route('users.index');
    }

    public function destroy(User $user)
    {
        ACL::allowOnly([Permission::CAN_DELETE_USERS]);

        User::findOrFail($user->id)->delete();
    }
}
