<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index(Request $request) {
        $limit = $request->query('limit');
        $search = $request->query('search');
        $sort_by = $request->query('sortBy');
        $order_by = $request->query('orderBy');

        $users = User
            ::where('username','LIKE',"%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->when($sort_by, fn ($query) => $query->orderBy($sort_by, $order_by))
            ->paginate($limit);

        return Inertia::render('UserManagement/Index', [
            'users' => $users
        ]);
    }

    public function create() {
        return Inertia::render('UserManagement/Create');
    }

    public function store(UserRequest $request) {
        User::create($request->all());
        return to_route('user-management.index');
    }

    public function edit(User $user) {
        return Inertia::render('UserManagement/Edit', [
            'users' => $user->only('id', 'username', 'email'),
        ]);
    }

    public function update(User $user, UserRequest $request) {
        if ($request->password) {
            $user->update($request->only('username', 'email', 'password'));
        } else {
            $user->update($request->only('username', 'email'));
        }

        return to_route('user-management.index');
    }

    public function destroy(User $user) {
        User::findOrFail($user->id)->delete();
    }
}
