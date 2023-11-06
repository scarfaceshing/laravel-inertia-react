<?php

namespace App\Http\Middleware;

use App\Models\Department;
use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
 /**
  * The root template that is loaded on the first page visit.
  *
  * @var string
  */
 protected $rootView = 'app';

 /**
  * Determine the current asset version.
  */
 public function version(Request $request): string|null
 {
  return parent::version($request);
 }

 /**
  * Define the props that are shared by default.
  *
  * @return array<string, mixed>
  */
 public function share(Request $request): array
 {
  $user = $request->user();
  $departments = Department::pluck('name');
  $positions = Position::pluck('name');
  $employee_photo = Storage::url('placeholder/no-image-employee.png');

  return array_merge(parent::share($request), [
      'auth' => [
          'user' => $user,
          'permissions' => $user ? $user->permissions->pluck('name') : null,
          'role' => $user ? $user->roles->pluck('name') : null,
      ],
      'lookups' => [
        'departments' => $departments,
        'positions' => $positions
      ],
      'placeholder' => [
        'employee_photo' => ''
      ],
      'ziggy' => function () use ($request) {
       return array_merge((new Ziggy)->toArray(), [
           'location' => $request->url(),
       ]);
      },
  ]);
 }
}
