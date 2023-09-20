<?php

namespace App\Http\Controllers;

use App\Models\User;
// use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index() {
        $request = request()->all();
        $users = User::all();

        return Inertia::render('UserManagement/Index', [
            'filters' => $request,
            'users' => $users
        ]);
    }
}