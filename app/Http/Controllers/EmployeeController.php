<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use Inertia\Inertia;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
 /**
  * Display a listing of the resource.
  *
  * @return \Illuminate\Http\Response
  */
 public function index(Request $request)
 {
  $search = $request->query('search');
  $sort_by = $request->query('sort_by');
  $order_by = $request->query('ordery_by');
  $limit = $request->query('limit');

  $employee = Employee
   ::where('employees.employee_number', 'LIKE', "%{$search}%")
   ->where('employees.first_name', 'LIKE', "%{$search}%")
   ->orWhere('employees.middle_name', 'LIKE', "%{$search}%")
   ->orWhere('employees.last_name', 'LIKE', "%{$search}%")
   ->when($sort_by, fn ($query) => $query->orderBy($sort_by, $order_by))
   ->paginate($limit);

  return Inertia::render('Employees/Index', [
   'data' => $employee
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
  * @param  \App\Http\Requests\StoreEmployeeRequest  $request
  * @return \Illuminate\Http\Response
  */
 public function store(StoreEmployeeRequest $request)
 {
  //
 }

 /**
  * Display the specified resource.
  *
  * @param  \App\Models\Employee  $employee
  * @return \Illuminate\Http\Response
  */
 public function show(Employee $employee)
 {
  //
 }

 /**
  * Show the form for editing the specified resource.
  *
  * @param  \App\Models\Employee  $employee
  * @return \Illuminate\Http\Response
  */
 public function edit(Employee $employee)
 {
  //
 }

 /**
  * Update the specified resource in storage.
  *
  * @param  \App\Http\Requests\UpdateEmployeeRequest  $request
  * @param  \App\Models\Employee  $employee
  * @return \Illuminate\Http\Response
  */
 public function update(UpdateEmployeeRequest $request, Employee $employee)
 {
  //
 }

 /**
  * Remove the specified resource from storage.
  *
  * @param  \App\Models\Employee  $employee
  * @return \Illuminate\Http\Response
  */
 public function destroy(Employee $employee)
 {
  //
 }
}
