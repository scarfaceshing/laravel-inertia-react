<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use App\ACL\ACL;
use App\Models\Permission;

class DashboardController extends Controller
{
 public function index()
 {
  ACL::allowOnly([Permission::CAN_ACCESS_INDEX_DASHBOARD]);

  return Inertia::render('Dashboard/Index', [
   'test' => 'test',
  ]);
 }
}
