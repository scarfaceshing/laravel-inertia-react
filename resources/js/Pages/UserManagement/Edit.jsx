import { Head } from '@inertiajs/react';
import { useState } from 'react';
import BreadCrump from '@/Components/BreadCrump';
import Form from '@/Pages/UserManagement/Form';
import MainLayout from '@/Layouts/MainLayout';

export default function Edit(props) {
  const formData = {
    id: props.users.id,
    email: props.users.email,
    username: props.users.username,
    password: '',
    password_confirmation: '',
    isEdit: true,
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
