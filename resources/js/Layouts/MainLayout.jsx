import Navigation from '@/Components/Navigation';
import Sidebar from '@/Components/Sidebar';
import { Dashboard, Person } from '@/icons';
import {
  CAN_ACCESS_INDEX_DASHBOARD,
  CAN_ACCESS_INDEX_EMLOYEE_MANAGEMENT,
  CAN_ACCESS_INDEX_HUMAN_RESOURCE,
  CAN_ACCESS_INDEX_PERMISSIONS,
  CAN_ACCESS_INDEX_ROLES,
  CAN_ACCESS_INDEX_USERS,
} from '@/constants';

export default function Authenticated({ auth, header, children }) {
  const links = [
    {
      path: route('dashboard.index'),
      icon: <Dashboard />,
      name: 'Dashboard',
      access: {
        type: 'allow_any',
        permissions: [CAN_ACCESS_INDEX_DASHBOARD],
      },
    },
    {
      icon: <Person />,
      name: 'Human Resource',
      access: {
        type: 'allow_only',
        permissions: [CAN_ACCESS_INDEX_HUMAN_RESOURCE],
      },
      children: [
        {
          path: route('employees.index'),
          name: 'Employees Management',
          access: {
            type: 'allow_only',
            permissions: [CAN_ACCESS_INDEX_EMLOYEE_MANAGEMENT],
          },
        },
      ],
    },
    {
      icon: <Person />,
      name: 'User Management',
      access: {
        type: 'allow_only',
        permissions: [CAN_ACCESS_INDEX_USERS],
      },
      children: [
        {
          path: route('users.index'),
          name: 'Users',
          access: {
            type: 'allow_only',
            permissions: [CAN_ACCESS_INDEX_USERS],
          },
        },
        {
          path: route('roles.index'),
          name: 'Roles',
          access: {
            type: 'allow_only',
            permissions: [CAN_ACCESS_INDEX_ROLES],
          },
        },
        {
          path: route('permissions.index'),
          name: 'Permissions',
          access: {
            type: 'allow_only',
            permissions: [CAN_ACCESS_INDEX_PERMISSIONS],
          },
        },
      ],
    },
  ];

  return (
    <div className="min-h-screen bg-gray-100">
      <div className="min-w-screen flex">
        <Sidebar links={links} auth={auth} />
        <div className="w-full sm:ml-64">
          <Navigation auth={auth} />
          <div className="p-4 rounded-lg">
            {header && (
              <header className="bg-white shadow">
                <div className="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">{header}</div>
              </header>
            )}
            <main>{children}</main>
          </div>
        </div>
      </div>
    </div>
  );
}
