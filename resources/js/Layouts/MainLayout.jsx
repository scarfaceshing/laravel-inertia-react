import Navigation from '@/Components/Navigation';
import Sidebar from '@/Components/Sidebar';
import { Dashboard, Person } from '@/icons';

export default function Authenticated({ auth, header, children }) {
  return (
    <div className="min-h-screen bg-gray-100">
      <div className="min-w-screen flex">
        <Sidebar auth={auth} />
        <div className="p-4 sm:ml-64 sm:pl-8 w-full">
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
