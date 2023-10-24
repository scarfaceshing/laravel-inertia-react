<?php

namespace App\Http\Controllers;

use App\ACL\ACL;
use App\Http\Requests\EmployeeRequest;
use App\Models\Employee;
use App\Models\Permission;
use App\Models\Phone;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Inertia\Inertia;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public const URL = '/employees';

    public function index(Request $request)
    {
        ACL::allowOnly([Permission::CAN_ACCESS_INDEX_EMPLOYEES]);

        $search = $request->query('search');
        $sort_by = $request->query('sortBy');
        $order_by = $request->query('orderBy');
        $limit = $request->query('limit');

        $employees = Employee::where('id_number', 'LIKE', "%{$search}%")
            ->orWhere('employees.first_name', 'LIKE', "%{$search}%")
            ->orWhere('employees.middle_name', 'LIKE', "%{$search}%")
            ->orWhere('employees.last_name', 'LIKE', "%{$search}%")
            ->when($sort_by, fn ($query) => $query->orderBy($sort_by, $order_by))
            ->paginate($limit);

        return Inertia::render('Employees/Index', [
            'data' => $employees,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        ACL::allowOnly([Permission::CAN_ACCESS_CREATE_EMPLOYEES]);

        return Inertia::render('Employees/Create', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEmployeeRequest a $request
     * @return \Illuminate\Http\Response
     */
    public function store(EmployeeRequest $request)
    {
        ACL::allowOnly([Permission::CAN_STORE_EMPLOYEES]);

        $employee_details = $request->only(
            'first_name',
            'middle_name',
            'last_name',
            'birth_date',
            'email_address',
            'address',
            'hired_date',
            'regularization',
            'department',
            'position',
            'gender',
            'civil_status',
            'phone_number'
        );

        $user = User::create([
            'username' => Str::random(6),
            'email' => $employee_details['email_address'],
            'password' => Hash::make(Str::random(10)),
            'is_active' => false
        ]);

        $append_user = [
            'id_number' => $this->generateIdNumber(),
            'user_id' => $user->id,
            'employee_status' => true
        ];

        $employee = Employee::create([
            ...$append_user,
            ...$employee_details
        ]);

        collect($employee_details['phone_number'])->each(
            fn ($phone_number) =>
            Phone::create([
                'employee_id' => $employee->id,
                'phone_number' => $phone_number,
                'is_active' => true
            ])
        );


        return redirect()->route('employees.index')->with('message', 'Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
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
     * @return \Illuminate\Http\Response
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }

    private function generateIdNumber(): string {
        $id_number = (string) mt_rand(0, 9999);

        return $id_number;
    }
}
