import DynamicTable from '@/Components/DynamicTable';
import MainLayout from '@/Layouts/MainLayout';
import { formatDate } from '@/utils';
import { Head, Link, router } from '@inertiajs/react';
import { useEffect, useState } from 'react';

export default function Index(props) {
  const [search, setSearch] = useState('');

  useEffect(() => {
    router.get(
      '/user-management',
      {
        search: search,
        limit: 10,
        sort: 'id',
        orderBy: 'ASC',
      },
      { preserveState: true }
    );
  }, [search]);

  function sortColumn(sortBy, orderBy) {
    router.get(
      '/user-management',
      {
        search: search,
        limit: 10,
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
    },
    {
      column: 'username',
      name: 'Username',
    },
    {
      column: 'name',
      name: 'Name',
    },
    {
      column: 'email',
      name: 'Email',
    },
    {
      column: 'email_verified_at',
      name: 'Verified at',
      mutate: value => {
        return formatDate(value);
      },
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
      mutate: id => {
        return <Link href={route('user-management.edit', id)}>Edit {id}</Link>;
      },
    },
  ];

  return (
    <MainLayout auth={props.auth} errors={props.errors}>
      <Head title="User Management" />
      <div>
        <div className="pb-5">
          <h1 className="text-3xl text-gray-900">User Management</h1>
        </div>
        <div>
          <div className="bg-white p-2 rounded-lg">
            <div className="pb-5">
              <input type="text" className="text-sm" value={search} onChange={e => setSearch(e.target.value)}></input>
            </div>
            <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
              <Link href={route('user-management.create')}>Create</Link>
              <DynamicTable
                data={props.users}
                columns={columns}
                sortColumn={(sortBy, orderBy) => sortColumn(sortBy, orderBy)}
              />
            </div>
          </div>
        </div>
      </div>
    </MainLayout>
  );
}
