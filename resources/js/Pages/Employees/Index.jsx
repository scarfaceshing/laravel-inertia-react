import { Head, Link, router, useForm } from '@inertiajs/react';
import { useEffect, useState } from 'react';
import BreadCrump from '@/Components/BreadCrump';
import DynamicTable, { TableHeader } from '@/Components/DynamicTable';
import InputLabel from '@/Components/InputLabel';
import MainLayout from '@/Layouts/MainLayout';
import PrimaryButton from '@/Components/PrimaryButton';
import Select from '@/Components/Select';
import TextInput from '@/Components/TextInput';

export default function Index(props) {
  const [showEmployee, setShowEmployee] = useState(false);
  const lengthMenu = [10, 50, 100];

  const { data, setData, post, put, processing, errors, get } = useForm({
    search: null,
    limit: null,
    sortBy: null,
    orderBy: null,
    page: null,
  });

  useEffect(() => {
    setData({ ...data, search: '', limit: 10, sortBy: 'created_at', orderBy: 'ASC', page: 1 });
  }, []);

  const columns = [
    {
      column: 'id_number',
      name: 'ID #',
    },
    {
      column: 'first_name',
      name: 'First name',
    },
    {
      column: 'middle_name',
      name: 'Middle name',
    },
    {
      column: 'last_name',
      name: 'Last name',
    },
    {
      column: 'department',
      name: 'Department',
    },
    {
      column: 'position',
      name: 'Position',
    },
    {
      column: 'employee_status',
      name: 'Status',
    },
    {
      name: 'Actions',
      mutate: (value, data) => (
        <div className="grid grid-flow-col auto-cols-max md:auto-cols-min gap-x-2">
          <Link href={route('employees.show', data.id)}>View</Link>
          <span>Edit</span>
          <span>Delete</span>
        </div>
      ),
    },
  ];

  useEffect(() => {
    get(route('employees.index'), { preserveState: true, replace: true });
  }, [data]);

  function pageAction({ label, url }) {
    if (url === null || label === '...') return false;
    if (['&laquo; Previous', 'Next &raquo;'].includes(label)) {
      let page = url.split('=').splice('-1').toString();
      setData('page', parseInt(page));
    } else {
      setData('page', parseInt(label));
    }
  }

  return (
    <MainLayout auth={props.auth} errors={props.errors}>
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
                <Link href={route('employees.create')}>
                  <PrimaryButton>Create</PrimaryButton>
                </Link>
                <div className="flex justify-between py-2">
                  <div>
                    <InputLabel htmlFor="search">Search</InputLabel>
                    <TextInput
                      id="search"
                      className="text-sm"
                      onChange={event => setData('search', event.target.value)}
                    />
                  </div>
                  <div className="pt-5">
                    <Select options={lengthMenu} handleChange={value => setData('limit', value)} />
                  </div>
                </div>
              </TableHeader>
              <DynamicTable
                data={props.data.data}
                columns={columns}
                sortColumn={(sortBy, orderBy) => setData({ ...data, orderBy: orderBy, sortBy: sortBy })}
                totalPages={props.data.total}
                fromPage={props.data.from}
                toPage={props.data.to}
                links={props.data.links}
                pageAction={value => pageAction(value)}
              />
            </div>
          </div>
        </div>
      </div>
    </MainLayout>
  );
}
