<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\Utilities\Middleware;

class DashboardController extends Controller
{
    public function __construct()
    {
        $permissions = ['can_view_dashboard'];
        $permissions = Middleware::extractPermissions('allowOnly', $permissions);
        $this->middleware($permissions);
    }

    public function index()
    {
        return Inertia::render('Dashboard/Index', [
            'test' => 'test',
        ]);
    }
}
