import { Close } from '@/icons';
import { Head, useForm, router } from '@inertiajs/react';
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

export default function Index(props) {
  const [showModal, setShowModal] = useState(false);
  const lengthMenu = [5, 50, 100];

  const { data, setData, post, put, processing, errors, get } = useForm({
    search: null,
    limit: null,
    sortBy: null,
    orderBy: null,
    page: null,
  });

  useEffect(() => {
    setData({ ...data, search: '', limit: 5, sortBy: 'created_at', orderBy: 'ASC', page: 1 });
  }, []);

  const columns = [
    {
      column: 'employee_number',
      name: 'Employee #',
    },
    {
      column: 'first_name',
      name: 'First name',
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
                <PrimaryButton>Create</PrimaryButton>
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
      <Modal show={showModal}>
        <div className="flex justify-end">
          <div className="p-2" onClick={() => setShowModal(false)}>
            <Close />
          </div>
        </div>
        <div className="h-64 flex flex-col sm:justify-center items-center gap-2">
          <h1>Are you sure to delete?</h1>
          <div className="text-center mb-2"></div>
          <div className="flex gap-x-3">
            <PrimaryButton className="px-7">Yes</PrimaryButton>
            <SecondaryButton onClick={() => setShowModal(false)}>Cancel</SecondaryButton>
          </div>
        </div>
      </Modal>
    </MainLayout>
  );
}
