/**
 *
 * Redundancy code in DynamicTable
 *
 */

import { Close, Pen, Trash } from '@/icons';
import { formatDate } from '@/utils';
import { Head, router } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import BreadCrump from '@/Components/BreadCrump';
import DynamicTable, { TableHeader } from '@/Components/DynamicTable';
import InputLabel from '@/Components/InputLabel';
import MainLayout from '@/Layouts/MainLayout';
import Modal from '@/Components/Modal';
import PrimaryButton from '@/Components/PrimaryButton';
import SecondaryButton from '@/Components/SecondaryButton';
import Select from '@/Components/Select';
import TextInput from '@/Components/TextInput';
import { AllowOnly } from '@/Components/PermissionFilter';
import { CAN_ACCESS_INDEX_USERS } from '@/constants';

export default function Index(props) {
  const [search, setSearch] = useState('');
  const [showModal, setShowModal] = useState(false);
  const [userData, setUserData] = useState({});
  const [limit, setLimit] = useState(10);
  const lengthMenu = [10, 50, 100];
  const [currentPage, setCurrentPage] = useState(1);
  const [totalPages, setTotalPages] = useState(null);
  const [fromPage, setFromPage] = useState(null);
  const [toPage, setToPage] = useState(null);
  const [links, setLinks] = useState([]);

  useEffect(() => {
    router.get(
      route('users.index'),
      {
        search: search,
        limit: limit,
        sort: 'id',
        orderBy: 'ASC',
        page: currentPage,
      },
      {
        preserveState: true,
        onSuccess: ({ props }) => {
          setTotalPages(props.data.total);
          setFromPage(props.data.from);
          setToPage(props.data.to);
          setLinks(() => props.data.links);
        },
      }
    );
  }, [search, limit, currentPage]);

  function sortColumn(sortBy, orderBy) {
    router.get(
      route('users.index'),
      {
        search: search,
        limit: limit,
        sortBy: sortBy,
        orderBy: orderBy,
      },
      { preserveState: true }
    );
  }

  const columns = [
    {
      column: '_index',
      name: '#',
      sort: false,
    },
    {
      column: 'username',
      name: 'Username',
    },
    {
      column: 'email',
      name: 'Email',
    },
    {
      column: 'is_active',
      name: 'Active',
      mutate: value => (value === true ? 'Yes' : 'No'),
    },
    /**
     * Temporary comment
   {
      column: 'roles',
      name: ' Role',
      mutate: value => {
        return (
          <div className="flex gap-2">
            {value.length > 0 ? (
              value.map((role, index) => (
                <span className="bossrder bg-gray-900 text-white p-2 rounded-lg" key={index}>
                  {role.name}
                </span>
              ))
            ) : (
              <span>None</span>
            )}
          </div>
        );
      },
    },
     */
    {
      column: 'created_at',
      name: 'Created at',
      mutate: value => {
        return formatDate(value);
      },
    },
    {
      column: 'id',
      name: 'Action',
      sort: false,
      mutate: (value, data) => {
        return (
          <div className="flex gap-x-2">
            <SecondaryButton onClick={() => router.get(route('users.edit', value))}>
              <span className="text-blue-500">
                <Pen />
              </span>
            </SecondaryButton>
            <SecondaryButton onClick={() => onRemove(data)}>
              <span className="text-red-500">
                <Trash />
              </span>
            </SecondaryButton>
          </div>
        );
      },
    },
  ];

  function onRemove(data) {
    setShowModal(true);
    setUserData(() => data);
  }

  function remove(data) {
    router.delete(route('users.destroy', data.id), { onSuccess: () => setShowModal(false) });
  }

  function pageAction({ label, url }) {
    if (url === null || label === '...') return false;
    if (['&laquo; Previous', 'Next &raquo;'].includes(label)) {
      let page = url.split('=').splice('-1').toString();
      setCurrentPage(parseInt(page));
    } else {
      setCurrentPage(parseInt(label));
    }
  }

  return (
    <MainLayout auth={props.auth} errors={props.errors}>
      <AllowOnly permissions={[CAN_ACCESS_INDEX_USERS]} userPermissions={props.auth.permissions}>
        <Head title="User Management" />
        <div>
          <div className="pb-5">
            <BreadCrump
              path={[
                {
                  name: 'test',
                  icon: 'test',
                },
              ]}
            />
          </div>
          <div>
            <div className="bg-white p-2">
              <div className="overflow-hidden">
                <TableHeader>
                  <PrimaryButton onClick={() => router.get(route('users.create'))}>Create</PrimaryButton>
                  <div className="flex justify-between py-2">
                    <div>
                      <InputLabel htmlFor="search">Search</InputLabel>
                      <TextInput
                        id="search"
                        className="text-sm"
                        value={search}
                        onChange={e => setSearch(e.target.value)}
                      />
                    </div>
                    <div className="pt-5">
                      <Select options={lengthMenu} handleChange={value => setLimit(value)} />
                    </div>
                  </div>
                </TableHeader>
                <DynamicTable
                  data={props.data.data}
                  columns={columns}
                  sortColumn={(sortBy, orderBy) => sortColumn(sortBy, orderBy)}
                  totalPages={totalPages}
                  fromPage={fromPage}
                  toPage={toPage}
                  links={links}
                  pageAction={value => pageAction(value)}
                />
              </div>
            </div>
          </div>
        </div>
        <Modal show={showModal}>
          <div className="flex justify-end">
            <div className="p-2" onClick={() => setShowModal(false)}>
              <Close />
            </div>
          </div>
          <div className="h-64 flex flex-col sm:justify-center items-center gap-2">
            <h1>Are you sure to delete?</h1>
            <div className="text-center mb-2">
              <p>{userData.username}</p>
              <p>{userData.email}</p>
            </div>
            <div className="flex gap-x-3">
              <PrimaryButton className="px-7" onClick={() => remove(userData)}>
                Yes
              </PrimaryButton>
              <SecondaryButton onClick={() => setShowModal(false)}>Cancel</SecondaryButton>
            </div>
          </div>
        </Modal>
      </AllowOnly>
    </MainLayout>
  );
}
