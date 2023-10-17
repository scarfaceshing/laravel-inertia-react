import { Head, router } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import BreadCrump from '@/Components/BreadCrump';
import DynamicTable, { TableHeader } from '@/Components/DynamicTable';
import InputLabel from '@/Components/InputLabel';
import MainLayout from '@/Layouts/MainLayout';
import Select from '@/Components/Select';
import TextInput from '@/Components/TextInput';

export default function Index(props) {
  const [search, setSearch] = useState('');
  const [limit, setLimit] = useState(10);
  const lengthMenu = [10, 50, 100];
  const [currentPage, setCurrentPage] = useState(1);
  const [totalPages, setTotalPages] = useState(null);
  const [fromPage, setFromPage] = useState(null);
  const [toPage, setToPage] = useState(null);
  const [links, setLinks] = useState([]);

  useEffect(() => {
    router.get(
      route('roles.index'),
      {
        search: search,
        limit: limit,
        sort: 'created_at',
        orderBy: 'ASC',
        page: currentPage,
      },
      {
        preserveState: true,
        onSuccess: ({ props }) => {
          setTotalPages(props.roles.total);
          setFromPage(props.roles.from);
          setToPage(props.roles.to);
          setLinks(() => props.roles.links);
        },
      }
    );
  }, []);

  function sortColumn(sortBy, orderBy) {
    router.get(
      route('roles.index'),
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
      column: 'name',
      name: 'Name',
    },
    {
      column: 'description',
      name: 'Description',
    },
    {
      column: 'permissions',
      name: 'Permissions',
      mutate: permissions => {
        return permissions.map((item, key) => <div key={key}>{item.name}</div>);
      },
    },
  ];

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
      <Head title="Roles" />
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
                data={props.roles.data}
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
    </MainLayout>
  );
}
