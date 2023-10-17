import { Link } from '@inertiajs/react';
import { useEffect } from 'react';

export default function Breadcrumb({ path }) {
  return (
    <div>
      <nav className="flex" aria-label="Breadcrumb">
        <ol className="inline-flex items-center space-x-1 md:space-x-3 pl-1">
          {path &&
            path.map(item => {
              <li className="inline-flex items-center">
                <Link
                  href="#"
                  className="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white"
                ></Link>
              </li>;
            })}
        </ol>
      </nav>
    </div>
  );
}
