<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Utilities\Middleware;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PermissionController extends Controller
{
 public const ROLES_API_URL = '/roles';

 public function __construct()
 {
  $permissions = ['can_view_permissions'];
  $permissions = Middleware::extractPermissions('allowOnly', $permissions);
  $this->middleware($permissions);
 }

 /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
 public function index(Request $request)
 {
  $limit = $request->query('limit');
  $search = $request->query('search');
  $sort_by = $request->query('sortBy');
  $order_by = $request->query('orderBy');

  $permissions = Permission::where('name', 'LIKE', "%{$search}%")
   ->when($sort_by, fn ($query) => $query->orderBy($sort_by, $order_by))
   ->paginate($limit);

  return Inertia::render('Permissions/Index', [
      'permissions' => $permissions,
  ]);
 }

 /**
  * Show the form for creating a new resource.
  *
  * @return \Illuminate\Http\Response
  */
 public function create()
 {
  //
 }

 /**
  * Store a newly created resource in storage.
  *
  * @return \Illuminate\Http\Response
  */
 public function store(Request $request)
 {
  //
 }

 /**
  * Display the specified resource.
  *
  * @return \Illuminate\Http\Response
  */
 public function show(Roles $roles)
 {
  //
 }

 /**
  * Show the form for editing the specified resource.
  *
  * @return \Illuminate\Http\Response
  */
 public function edit(Roles $roles)
 {
  //
 }

 /**
  * Update the specified resource in storage.
  *
  * @return \Illuminate\Http\Response
  */
 public function update(Request $request, Roles $roles)
 {
  //
 }

 /**
  * Remove the specified resource from storage.
  *
  * @return \Illuminate\Http\Response
  */
 public function destroy(Roles $roles)
 {
  //
 }
}
