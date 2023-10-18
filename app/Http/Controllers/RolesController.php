<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\ACL\ACL;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RolesController extends Controller
{
 public const ROLES_API_URL = '/roles';

 /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
 public function index(Request $request)
 {
  ACL::allowOnly([Permission::CAN_ACCESS_INDEX_ROLES]);

  $limit = $request->query('limit');
  $search = $request->query('search');
  $sort_by = $request->query('sortBy');
  $order_by = $request->query('orderBy');

  $roles = Role::select('*')
   ->with('permissions')
   ->where('name', 'LIKE', "%{$search}%")
   ->when($sort_by, fn ($query) => $query->orderBy($sort_by, $order_by))
   ->with('permissions')
   ->paginate($limit);

  return Inertia::render('Roles/Index', [
      'roles' => $roles,
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
