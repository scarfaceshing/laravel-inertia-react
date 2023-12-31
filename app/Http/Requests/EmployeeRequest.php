<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Constants;

class EmployeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $reqularization = implode(',', Constants::REGULARIZATION);
        $sex = implode(',', Constants::SEX);
        $civil_status = implode(',', Constants::CIVIL_STATUS);

        return [
            'employee_number' => ['required', 'min:5', 'max:50', 'unique:employees,employee_number,' . $this->id . ',id'],
            'first_name' => ['required', 'max:150'],
            'middle_name' => ['max:150'],
            'last_name' => ['required'],
            'birth_date' => ['required', 'date'],
            'hired_date' => ['required', 'date|after:start_date'],
            'regularization' => ['required', 'in:' . $reqularization],
            'sex' => ['required', 'in:' . $sex],
            'civil_status' => ['required', 'in:' . $civil_status],
            'is_active' => ['required', 'boolean']
        ];
    }
}
