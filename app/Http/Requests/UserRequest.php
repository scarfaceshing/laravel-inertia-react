<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
 public function authorize()
 {
  return true;
 }

 public function rules()
 {
  return [
   'username' => ['required', 'min:5', 'max:50', 'unique:users,username,' . $this->id . ',id'],
   'email' => ['required', 'email', 'min:5', 'max:50', 'unique:users,email,' . $this->id . ',id'],
   'password' => [Rule::when(($this->password || $this->password_confirmation), fn () => ['required', 'confirmed', 'min:6', 'max:50'])],
   'is_active' => ['boolean'],
   'permissions.*.*' => ['exists:App\Models\Permission:name'],
  ];
 }
}
