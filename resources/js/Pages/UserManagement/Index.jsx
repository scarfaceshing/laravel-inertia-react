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
import TextInput from '@/Components/TextInput';
import Select from '@/Components/Select';

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
      route('user-management.index'),
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
          setTotalPages(props.users.total);
          setFromPage(props.users.from);
          setToPage(props.users.to);
          setLinks(link => props.users.links);
          console.log(links);
        },
      }
    );
  }, [search, limit, currentPage]);

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

  function pageAction({ label, url }) {
    if (url === null || label === '...') return false;
    if (['&laquo; Previous', 'Next &raquo;'].includes(label)) {
      let page = url.split('=').splice('-1').toString();
      console.log(page);
      setCurrentPage(parseInt(page));
    } else {
      setCurrentPage(parseInt(label));
    }
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
                <PrimaryButton onClick={() => router.get(route('user-management.create'))}>Create</PrimaryButton>
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
                data={props.users.data}
                columns={columns}
                sortColumn={(sortBy, orderBy) => sortColumn(sortBy, orderBy)}
                pagination={props.users}
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
    </MainLayout>
  );
}
