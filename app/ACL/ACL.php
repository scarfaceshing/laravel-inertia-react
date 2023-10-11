<?php

namespace App\ACL;

use App\Exceptions\InvalidPermission;

class ACL
{
 public static function allowAny(array $permissions = []): void
 {
  $user_permissions = auth()->user()->permissions;

  $test = $user_permissions->whereIn('name', ['can_view_users']);
  dd($test);
 }
}
