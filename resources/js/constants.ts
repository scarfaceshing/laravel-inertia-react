export const l_LTS = 'DD/MM/YYYY H:M:s';

export const CAN_VIEW_DASHBOARD = 'can_view_dashboard';

export const CAN_VIEW_USERS = 'can_view_users';
export const CAN_ADD_USERS = 'can_add_users';
export const CAN_EDIT_USERS = 'can_edit_users';
export const CAN_DELETE_USERS = 'can_delete_users';

export const CAN_VIEW_ROLES = 'can_view_roles';

export const CAN_VIEW_PERMISSIONS = 'can_view_permissions';

export const CAN_CHANGE_ROLE = 'can_change_role';

export const ALL_PERMISSIONS = [
    CAN_VIEW_DASHBOARD,
    CAN_VIEW_USERS,
    CAN_ADD_USERS,
    CAN_EDIT_USERS,
    CAN_DELETE_USERS,
    CAN_VIEW_ROLES,
    CAN_VIEW_PERMISSIONS,
    CAN_CHANGE_ROLE,
];

export const ADMINISTRATOR = 'administrator';
export const INFORMATION_TECHNOLOGY = 'information_technology';
export const HUMAN_RESOURCE = 'human_resource'

export const ALL_ROLES = [
 ADMINISTRATOR,
 INFORMATION_TECHNOLOGY,
 HUMAN_RESOURCE
];

export const ROLES_AND_PERMISSIONS = [
 {
  name: ADMINISTRATOR,
  permissions: ALL_PERMISSIONS
 },
 {
  name: INFORMATION_TECHNOLOGY,
  permissions: []
 },
 {
  name: HUMAN_RESOURCE,
  permissions: []
 }
];