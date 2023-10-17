export const l_LTS = 'DD/MM/YYYY H:M:s';

export const CAN_ACCESS_INDEX_DASHBOARD = 'can_access_index_dashboard';

 export const CAN_ACCESS_INDEX_USERS = 'can_access_index_users';
 export const CAN_ACCESS_CREATE_USERS = 'can_access_create_users';
 export const CAN_ACCESS_EDIT_USERS = 'can_access_edit_users';
 export const CAN_CHANGE_USERS = 'can_change_role_users';
 export const CAN_CHANGE_PERMISSIONS_USERS = 'can_change_permission_users';
 export const CAN_STORE_USER = 'can_store_user';
 export const CAN_UPDATE_USER = 'can_update_user';
 export const CAN_DELETE_USERS = 'can_delete_users';

 export const CAN_ACCESS_INDEX_ROLES = 'can_access_index_roles';

 export const CAN_ACCESS_INDEX_PERMISSIONS = 'can_access_index_permissions';

 export const CAN_ACCESS_INDEX_HUMAN_RESOURCE = 'can_access_index_human_resources';
 export const CAN_ACCESS_INDEX_INFORMATION_TECHNOLOGY = 'can_access_index_information_technology';
 export const CAN_ACCESS_INDEX_EMLOYEE_MANAGEMENT = 'can_access_index_emloyee_management';

 export const ALL_PERMISSIONS = [
  CAN_ACCESS_CREATE_USERS,
  CAN_ACCESS_EDIT_USERS,
  CAN_ACCESS_INDEX_DASHBOARD,
  CAN_ACCESS_INDEX_HUMAN_RESOURCE,
  CAN_ACCESS_INDEX_INFORMATION_TECHNOLOGY,
  CAN_ACCESS_INDEX_PERMISSIONS,
  CAN_ACCESS_INDEX_ROLES,
  CAN_ACCESS_INDEX_USERS,
  CAN_CHANGE_PERMISSIONS_USERS,
  CAN_CHANGE_USERS,
  CAN_DELETE_USERS,
  CAN_STORE_USER,
  CAN_UPDATE_USER
 ];

 export const ADMINISTRATOR = 'administrator';
 export const HUMAN_RESOURCE = 'human_resource';
 export const INFORMATION_TECHNOLOGY = 'information_technology';

 export const ALL_ROLES = [
     ADMINISTRATOR,
     HUMAN_RESOURCE,
     INFORMATION_TECHNOLOGY,
 ];

export const ROLES_AND_PERMISSIONS = [
 {
  name: ADMINISTRATOR,
  permissions: ALL_PERMISSIONS
 },
 {
  name: INFORMATION_TECHNOLOGY,
  permissions: [
    CAN_ACCESS_INDEX_INFORMATION_TECHNOLOGY
  ]
 },
 {
  name: HUMAN_RESOURCE,
  permissions: [
    CAN_ACCESS_INDEX_HUMAN_RESOURCE
  ]
 }
];