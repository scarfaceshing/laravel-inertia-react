<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
 public const ADMINISTRATOR = 'administrator';
 public const HUMAN_RESOURCE = 'human_resource';
 public const INFORMATION_TECHNOLOGY = 'information_technology';

 public const ALL_ROLES = [
  self::ADMINISTRATOR,
  self::HUMAN_RESOURCE,
  self::INFORMATION_TECHNOLOGY
 ];
}
