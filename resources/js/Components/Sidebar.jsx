import { Link } from '@inertiajs/react';
import { CarretDown } from '@/icons';
import { useRef } from 'react';
import { Allow, AllowAny, AllowOnly } from '@/Components/PermissionFilter';

export default function Sidebar({ links, auth }) {
  const collapse = useRef(null);

  function handleCollapse(index) {
    collapse[index].classList.toggle('hidden');
  }

  return (
    <aside className="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0">
      <div className="h-full px-3 py-4 overflow-y-auto sidebar">
        <ul className="space-y-2 font-medium">
          {links &&
            links.map((link, index) => (
              <li key={index}>
                <Allow auth={auth} type={link.access.type} permissions={link.access.permissions}>
                  {!link.children ? (
                    <Link
                      href={link.path}
                      className="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-800 group"
                    >
                      {link.icon}
                      <span className="ml-3">{link.name}</span>
                    </Link>
                  ) : (
                    <>
                      <button
                        type="button"
                        className="flex items-center w-full p-2 text-base text-gray-100 transition duration-75 rounded-lg group hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-800 group"
                        aria-controls="dropdown-example"
                        data-collapse-toggle="dropdown-example"
                        onClick={() => handleCollapse(index)}
                      >
                        {link.icon}
                        <span className="flex-1 ml-3 text-left whitespace-nowrap">{link.name}</span>
                        <CarretDown />
                      </button>
                      <ul id="dropdown-example" ref={element => (collapse[index] = element)} className="py-2 space-y-2">
                        {link.children.map((child, index) => (
                          <li key={index}>
                            <Link
                              href={child.path}
                              className="flex items-center w-full p-2 text-gray-100 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-800"
                            >
                              {child.name}
                            </Link>
                          </li>
                        ))}
                      </ul>
                    </>
                  )}
                </Allow>
              </li>
            ))}
        </ul>
      </div>
    </aside>
  );
}
