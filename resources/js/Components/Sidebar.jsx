import { CarretDown, Menu } from '@/icons';
import { useState } from 'react';
import { Allow, AllowAny, AllowOnly } from '@/Components/PermissionFilter';
import SidebarList, { DropdownLink } from './SidebarList';
import { Dashboard, Person } from '@/icons';

export default function Sidebar({ auth }) {
  return (
    <aside className="fixed top-0 left-0 z-40 w-fit h-screen transition-transform -translate-x-full sm:translate-x-0">
      <div className="h-full px-3 py-4 overflow-y-auto sidebar">
        <SidebarList>
          <SidebarList.List to={route('dashboard.index')}>
            <Dashboard />
            <span className="ml-3">Dashboard</span>
          </SidebarList.List>
          <SidebarList.DropdownList>
            <SidebarList.DropdownList.HeaderList>
              <Person className="flex-shrink-0 w-5 h-5 transition duration-75 " />
              <span className="flex-1 ml-3 whitespace-nowrap">Employees Management</span>
            </SidebarList.DropdownList.HeaderList>
            <SidebarList.DropdownList.MenuList>
              <DropdownLink to={route('employees.index')}>
                <span className="ml-3">Employees</span>
              </DropdownLink>
            </SidebarList.DropdownList.MenuList>
          </SidebarList.DropdownList>
          <SidebarList.DropdownList>
            <SidebarList.DropdownList.HeaderList>
              <Person className="flex-shrink-0 w-5 h-5 transition duration-75 " />
              <span className="flex-1 ml-3 whitespace-nowrap">Users Management</span>
            </SidebarList.DropdownList.HeaderList>
            <SidebarList.DropdownList.MenuList>
              <DropdownLink to={route('users.index')}>
                <span className="ml-3">Users</span>
              </DropdownLink>
              <DropdownLink to={route('permissions.index')}>
                <span className="ml-3">Permissions</span>
              </DropdownLink>
              <DropdownLink to={route('roles.index')}>
                <span className="ml-3">Roles</span>
              </DropdownLink>
            </SidebarList.DropdownList.MenuList>
          </SidebarList.DropdownList>
        </SidebarList>
      </div>
    </aside>
  );
}
