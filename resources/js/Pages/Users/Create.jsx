import { Head } from '@inertiajs/react';
import BreadCrump from '@/Components/BreadCrump';
import Form from '@/Pages/Users/Form';
import MainLayout from '@/Layouts/MainLayout';
import { ADMINISTRATOR } from '@/constants';
import { useEffect, useState } from 'react';

export default function Create(props) {
  const [form, setForm] = useState({
    email: '',
    username: '',
    password: '',
    password_confirmation: '',
    permission: [],
  });

  return (
    <MainLayout auth={props.auth} errors={props.errors}>
      <Head title="User Management" />
      <div className="pb-5">
        <BreadCrump />
      </div>
      <div className="grid grid-rows-2 gap-y-5">
        <div>
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
            <Form data={form} />
          </div>
        </div>
      </div>
    </MainLayout>
  );
}
