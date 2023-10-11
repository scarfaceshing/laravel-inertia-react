<?php

namespace App\ACL;

use App\Exceptions\InvalidPermission;
use Illuminate\Support\Collection;

class ACL
{
 public static function allowAny(array $permissions = []): void
 {
  $user_permissions = auth()->user()->permissions->pluck('name');

  $is_ok = $user_permissions->contains(fn ($permission) => in_array($permission, $permissions));

  if (!$is_ok) {
   throw new InvalidPermission;
  }
 }

 public static function allowOnly(array $permissions = []): void
 {
  $user_permissions = auth()->user()->permissions->pluck('name');

  $is_ok = collect($permissions)->every(function ($permission) use ($user_permissions) {
   return $user_permissions->contains($permission);
  });

  if (!$is_ok) {
   throw new InvalidPermission;
  }
 }
}
