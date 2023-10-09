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
      'username' => ['required', 'min:5', 'max:50', Rule::unique(User::class)->ignore($this->id)],
      'email' => ['required', 'email', 'min:5', 'max:50', Rule::unique(User::class)->ignore($this->id)],
      'password' => [Rule::when(($this->password || $this->password_confirmation), fn () => ['required', 'confirmed', 'min:6', 'max:50'])],
      'role' => ['required'],
  ];
 }
}
