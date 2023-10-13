import MainLayout from '@/Layouts/MainLayout';
import { Head, useForm } from '@inertiajs/react';
import { useEffect } from 'react';

export default function Index(props) {
  const { data, setData, post, put, processing, errors, get } = useForm({
    search: '',
    length: 10,
    sort: 'id',
    orderBy: 'ASC',
    page: 1,
  });

  useEffect(() => {
    setData('search', '15Z9J0DA');
    setData('length', 1);
    setData('sort', 'created_at');
    setData('orderBy', 'ASC');
    setData('page', 1);
    get(route('employees.index'), data);
  }, []);

  return (
    <MainLayout auth={props.auth} errors={props.errors}>
      <Head title="Employees" />

      <div className="py-6">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900">Employees</div>
            <div>{JSON.stringify(props.data)}</div>
          </div>
        </div>
      </div>
    </MainLayout>
  );
}
