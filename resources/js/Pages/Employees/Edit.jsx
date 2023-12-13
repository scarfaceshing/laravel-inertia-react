import { Head } from '@inertiajs/react';
import { useState } from 'react';
import BreadCrump from '@/Components/BreadCrump';
import Form from '@/Pages/Employees/Form';
import MainLayout from '@/Layouts/MainLayout';

export default function Edit(props) {
  const [form, setForm] = useState({
    id: props.data.id,
    idNumber: props.data.id_number,
    firstName: props.data.first_name,
    middleName: props.data.middle_name,
    lastName: props.data.last_name,
    birthDate: props.data.birth_date,
    hiredDate: props.data.hired_date,
    employeeStatus: props.data.employee_status,
    department: props.data.department,
    position: props.data.position,
    gender: props.data.gender,
    civil_status: props.data.civil_status,
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
            <Form data={form} lookups={props.lookups} />
          </div>
        </div>
      </div>
    </MainLayout>
  );
}
