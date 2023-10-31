import { Person, CarretDown, CaretRight } from '@/icons';
import { Link as InertiaLink } from '@inertiajs/react';
import { useState, createContext, useContext, useEffect, useRef } from 'react';

export function SidebarList({ children }) {
  return <ul className="space-y-2 font-medium">{children}</ul>;
}

const List = ({ to, children }) => {
  return (
    <InertiaLink
      href={to}
      className="flex items-center p-2 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-800 group"
    >
      {children}
    </InertiaLink>
  );
};

const HeaderList = ({ children }) => {
  return (
    <button
      onClick={() => console.log('collapse')}
      type="button"
      className="flex items-center w-full p-2 text-base text-gray-100 transition duration-75 rounded-lg group hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-800 group"
    >
      {children}
      <CarretDown />
    </button>
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
        className="flex items-center w-full p-2 text-gray-100 transition duration-75 rounded-lg pl-10 group hover:bg-gray-100 dark:hover:bg-gray-700 hover:text-gray-800"
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
