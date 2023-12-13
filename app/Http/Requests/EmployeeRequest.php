<?php

namespace App\Http\Requests;

use App\Constants\Constants;
use App\Models\Department;
use App\Models\Position;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $employee_status = implode(',', Constants::EMPLOYEE_STATUS);
        $gender = implode(',', Constants::GENDER);
        $civil_status = implode(',', Constants::CIVIL_STATUS);
        $departments = implode(',', Department::ALL_DEPARTMENTS);
        $positions = implode(',', Position::ALL_POSITIONS);

        return [
            'first_name' => ['required', 'max:150'],
            'middle_name' => ['max:150'],
            'last_name' => ['required'],
            'birth_date' => ['required', 'date'],
            'address' => ['required', 'max:255'],
            'hired_date' => ['date', 'after:start_date'],
            'employee_status' => ['in:'.$employee_status],
            'gender' => ['required', 'in:'.$gender],
            'civil_status' => ['required', 'in:'.$civil_status],
            'department' => ['required', 'in:'.$departments],
            'position' => ['required', 'in:'.$positions],
            'phone_number.*.*' => ['required|numeric|digits:10'],
            'photo' => ['dimensions:min_width=100,min_height=200','mimes:jpeg,bmp,png'],
        ];
    }
}
