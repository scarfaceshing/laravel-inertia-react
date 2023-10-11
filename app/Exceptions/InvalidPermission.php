<?php

namespace App\Exceptions;

use Exception;

class InvalidPermission extends Exception
{
 public $permissions;

 public function __construct(array $permissions = [])
 {
  $this->permissions = $permissions;
 }

 public function context(): array
 {
  return [
   'user' => auth()->user(),
   'permissions' => $this->permissions
  ];
 }
}
