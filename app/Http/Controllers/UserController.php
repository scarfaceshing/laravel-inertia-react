<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
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
            ->when($sort_by, fn ($query) => $query->orderBy($sort_by, $order_by))
            ->limit($limit)
            ->get();

        return Inertia::render('UserManagement/Index', [
            'users' => $users,
        ]);
    }

    public function create() {
        return Inertia::render('UserManagement/Create');
    }

    public function edit(User $user) {
        
        return Inertia::render('UserManagement/Edit', [
            'user' => $user,
        ]);
    }
}
