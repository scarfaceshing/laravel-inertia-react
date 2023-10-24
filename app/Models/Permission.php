<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
 public const CAN_ACCESS_INDEX_DASHBOARD = 'can_access_index_dashboard';

 public const CAN_ACCESS_INDEX_USERS = 'can_access_index_users';
 public const CAN_ACCESS_CREATE_USERS = 'can_access_create_users';
 public const CAN_ACCESS_EDIT_USERS = 'can_access_edit_users';
 public const CAN_STORE_USERS = 'CAN_STORE_USERS';
 public const CAN_UPDATE_USERS = 'can_update_user';
 public const CAN_DELETE_USERS = 'can_delete_users';
 public const CAN_CHANGE_ROLE_USERS = 'can_change_role_users';
 public const CAN_CHANGE_PERMISSIONS_USERS = 'can_change_permission_users';

 public const CAN_ACCESS_INDEX_ROLES = 'can_access_index_roles';

 public const CAN_ACCESS_INDEX_PERMISSIONS = 'can_access_index_permissions';

 public const CAN_ACCESS_INDEX_EMPLOYEES = 'can_access_index_employees';
 public const CAN_ACCESS_CREATE_EMPLOYEES = 'can_access_create_employees';
 public const CAN_STORE_EMPLOYEES = 'can_store_employees';

 public const CAN_ACCESS_INDEX_INFORMATION_TECHNOLOGY = 'can_access_index_information_technology';

 public const ALL_PERMISSIONS_HUMAN_RESOURCE = [
     self::CAN_ACCESS_INDEX_EMPLOYEES,
     self::CAN_ACCESS_CREATE_EMPLOYEES,
     self::CAN_STORE_EMPLOYEES
 ];

 public const ALL_PERMISSIONS_INFORMATION_TECHNOLOGY = [
     self::CAN_ACCESS_INDEX_INFORMATION_TECHNOLOGY,
 ];

 public const ALL_PERMISSIONS = [
     self::CAN_ACCESS_INDEX_DASHBOARD,
     self::CAN_ACCESS_INDEX_USERS,
     self::CAN_ACCESS_CREATE_USERS,
     self::CAN_ACCESS_EDIT_USERS,
     self::CAN_STORE_USERS,
     self::CAN_DELETE_USERS,
     self::CAN_ACCESS_INDEX_ROLES,
     self::CAN_ACCESS_INDEX_PERMISSIONS,
     self::CAN_CHANGE_ROLE_USERS,
     self::CAN_CHANGE_PERMISSIONS_USERS,
     self::CAN_UPDATE_USERS,
     ...self::ALL_PERMISSIONS_HUMAN_RESOURCE,
     ...self::ALL_PERMISSIONS_INFORMATION_TECHNOLOGY,
 ];
}
