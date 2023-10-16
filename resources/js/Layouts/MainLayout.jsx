import Navigation from '@/Components/Navigation';
import Sidebar from '@/Components/Sidebar';
import { Dashboard, Person } from '@/icons';

export default function Authenticated({ auth, header, children }) {
  const links = [
    {
      path: route('dashboard.index'),
      icon: <Dashboard />,
      name: 'Dashboard',
    },
    {
      icon: <Person />,
      name: 'Human Resource',
      children: [
        {
          path: route('employees.index'),
          name: 'Employees Management',
        },
      ],
    },
    {
      icon: <Person />,
      name: 'User Management',
      children: [
        {
          path: route('users.index'),
          name: 'Users',
        },
        {
          path: route('roles.index'),
          name: 'Roles',
        },
        {
          path: route('permissions.index'),
          name: 'Permissions',
        },
      ],
    },
  ];

  return (
    <div className="min-h-screen bg-gray-100">
      <div className="min-w-screen flex">
        <Sidebar links={links} />
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
