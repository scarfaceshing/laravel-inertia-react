<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
 public const CAN_ACCESS_INDEX_DASHBOARD = 'can_view_dashboard';

 public const CAN_ACCESS_INDEX_USERS = 'can_access_index_users';
 public const CAN_ACCESS_CREATE_USERS = 'can_access_create_users';
 public const CAN_ACCESS_EDIT_USERS = 'can_access_edit_users';

 public const CAN_UPDATE_USER = 'can_update_user';
 public const CAN_STORE_USER = 'can_store_user';
 public const CAN_DELETE_USERS = 'can_delete_users';

 public const CAN_ACCESS_INDEX_ROLES = 'can_access_index_roles';

 public const CAN_ACCESS_INDEX_PERMISSIONS = 'can_access_index_permissions';

 public const ALL_PERMISSIONS = [
  self::CAN_ACCESS_INDEX_DASHBOARD,
  self::CAN_ACCESS_INDEX_USERS,
  self::CAN_ACCESS_CREATE_USERS,
  self::CAN_ACCESS_EDIT_USERS,
  self::CAN_STORE_USER,
  self::CAN_DELETE_USERS,
  self::CAN_ACCESS_INDEX_ROLES,
  self::CAN_ACCESS_INDEX_PERMISSIONS
 ];
}
