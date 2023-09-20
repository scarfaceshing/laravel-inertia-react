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

        $users = User
            ::where('username','LIKE',"%{$search}%")
            ->limit($limit)
            ->get();

        return Inertia::render('UserManagement/Index', [
            'users' => $users,
        ]);
    }
}
