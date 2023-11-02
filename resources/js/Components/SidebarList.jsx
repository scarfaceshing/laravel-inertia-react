import { CaretRight, CarretDown, Person } from '@/icons';
import { Link as InertiaLink, Link } from '@inertiajs/react';
import { createContext, useContext, useEffect, useRef, useState } from 'react';
import { Menu } from '@/icons';

const SidebarContext = createContext();

export function SidebarList({ children }) {
  const [collapse, setCollapse] = useState(false);

  return (
    <SidebarContext.Provider value={{ collapse: collapse }}>
      <ul className="space-y-2 font-medium">
        <div className="flex justify-between border-b-2 pb-2">
          <h1 className="text-2xl">Bredco</h1>
          <button type="button" className="hover:bg-white hover:text-gray-900 p-1 hover:p-1 rounded-lg">
            <Menu className="w-8 h-8" />
          </button>
        </div>
        {children}
      </ul>
    </SidebarContext.Provider>
  );
}

const List = ({ to, children }) => {
  return (
    <InertiaLink
      href={to}
      className="flex items-center p-2 rounded-lg group text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-800"
    >
      {children}
    </InertiaLink>
  );
};

const HeaderList = ({ children }) => {
  return (
    <Link
      onClick={() => console.log('collapse')}
      className="flex items-center p-2 group text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-800 rounded-lg"
    >
      {children}
      <CarretDown className="pl-5" />
    </Link>
  );
};

const MenuList = ({ children }) => {
  return (
    <ul id="dropdown-example" className="py-2 space-y-2">
      <>{children}</>
    </ul>
  );
};

const DropdownList = ({ children }) => {
  return <>{children}</>;
};

export const DropdownLink = ({ to, children }) => {
  return (
    <li>
      <InertiaLink
        href={to}
        className="flex items-center w-full p-2 transition duration-75 rounded-lg pl-10 group text-gray-100 hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-800"
      >
        {children}
      </InertiaLink>
    </li>
  );
};

SidebarList.List = List;
SidebarList.DropdownList = DropdownList;
SidebarList.DropdownList.HeaderList = HeaderList;
SidebarList.DropdownList.MenuList = MenuList;

export default SidebarList;
