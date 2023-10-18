<?php

namespace App\Http\Controllers;

use App\ACL\ACL;
use App\Models\Permission;
use Inertia\Inertia;

class DashboardController extends Controller
{
 public function index()
 {
  ACL::allowAny([Permission::CAN_ACCESS_INDEX_DASHBOARD]);

  return Inertia::render('Dashboard/Index', [
      'test' => 'test',
  ]);
 }
}
