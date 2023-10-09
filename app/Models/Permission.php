<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
 public const CAN_VIEW_DASHBOARD = 'can_view_dashboard';

 public const CAN_VIEW_USERS = 'can_view_users';

 public const CAN_ADD_USERS = 'can_add_users';

 public const CAN_EDIT_USERS = 'can_edit_users';

 public const CAN_DELETE_USERS = 'can_delete_users';

 public const CAN_VIEW_ROLES = 'can_view_roles';

 public const CAN_VIEW_PERMISSIONS = 'can_view_permissions';

 public const CAN_CHANGE_ROLE = 'can_change_role';

 public const USER_PERMISSIONS = [
     self::CAN_VIEW_USERS,
     self::CAN_ADD_USERS,
     self::CAN_EDIT_USERS,
     self::CAN_DELETE_USERS,
     self::CAN_CHANGE_ROLE,
 ];
}
