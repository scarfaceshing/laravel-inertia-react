import { Head, usePage } from '@inertiajs/react';
import BreadCrump from '@/Components/BreadCrump';
import Form from '@/Pages/Users/Form';
import MainLayout from '@/Layouts/MainLayout';
import { getUrlId } from '@/utils';

export default function Edit(props) {
  const { url } = usePage();

  const formData = {
    id: getUrlId(url),
    email: props.users.email,
    username: props.users.username,
    password: '',
    password_confirmation: '',
    is_edit: true,
    permissions: props.permissions,
    roles: props.roles,
    is_active: props.users.is_active,
  };

  return (
    <MainLayout auth={props.auth} errors={props.errors}>
      <Head title="User Management" />
      <div className="pb-5">
        <BreadCrump />
      </div>
      <div className="grid grid-rows-2 gap-y-5">
        <div>
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
            <Form data={formData} />
          </div>
        </div>
      </div>
    </MainLayout>
  );
}
