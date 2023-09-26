import { Close, Pen, Trash } from '@/icons';
import { formatDate } from '@/utils';
import { Head, router } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import BreadCrump from '@/Components/BreadCrump';
import DynamicTable, { TableHeader } from '@/Components/DynamicTable';
import MainLayout from '@/Layouts/MainLayout';
import Modal from '@/Components/Modal';
import PrimaryButton from '@/Components/PrimaryButton';
import SecondaryButton from '@/Components/SecondaryButton';

export default function Index(props) {
  const [search, setSearch] = useState('');
  const [showModal, setShowModal] = useState(false);
  const [userData, setUserData] = useState({});
  const [limit, setLimit] = useState(10);

  useEffect(() => {
    router.get(
      route('user-management.index'),
      {
        search: search,
        limit: limit,
        sort: 'id',
        orderBy: 'ASC',
        page: 1,
      },
      { preserveState: true, onSuccess: data => data }
    );
  }, [search, limit]);

  function sortColumn(sortBy, orderBy) {
    router.get(
      route('user-management.index'),
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
            <SecondaryButton onClick={() => router.get(route('user-management.edit', value))}>
              <span className="text-blue-500">
                <Pen />
              </span>
            </SecondaryButton>
            <SecondaryButton onClick={() => onRemove(data)}>
              <Trash />
            </SecondaryButton>
          </div>
        );
      },
    },
  ];

  function onRemove(data) {
    setShowModal(true);
    setUserData(user => data);
  }

  function remove(data) {
    router.delete(route('user-management.destroy', data.id), { onSuccess: () => setShowModal(false) });
  }

  return (
    <MainLayout auth={props.auth} errors={props.errors}>
      <Head title="User Management" />
      <div>
        <div className="pb-5">
          <BreadCrump />
        </div>
        <div>
          <div className="bg-white p-2 rounded-lg">
            <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <TableHeader>
                <div>
                  <PrimaryButton onClick={() => router.get(route('user-management.create'))}>Create</PrimaryButton>
                  <input
                    type="text"
                    className="text-sm"
                    value={search}
                    onChange={e => setSearch(e.target.value)}
                  ></input>
                </div>
              </TableHeader>
              <DynamicTable
                data={props.users.data}
                columns={columns}
                sortColumn={(sortBy, orderBy) => sortColumn(sortBy, orderBy)}
                lengthMenu={[10, 50, 100]}
                onChangeLimit={value => setLimit(limit => value)}
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
    </MainLayout>
  );
}
