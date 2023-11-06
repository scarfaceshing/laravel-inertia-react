import { Head } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';
import { Link } from '@inertiajs/react';
import { ArrowLeft } from '@/icons';

export default function Show(props) {
  const { data } = props;

  return (
    <MainLayout auth={props.auth} errors={props.errors}>
      <Head title="User Management" />
      <div className="p-2 bg-white grid place-content-center">
        <div className="pb-2">
          <Link href={route('employees.index')}>
            <ArrowLeft />
          </Link>
        </div>
        <div className="w-96 grid grid-cols-2 gap-y-2">
          <div className="border-b font-semibold">ID number</div>
          <div className="border-b">{data.id_number}</div>
          <div className="border-b font-semibold">Full name</div>
          <div className="border-b">
            {data.first_name} {data.middle_name} {data.last_name}
          </div>
          <div className="border-b font-semibold">Birth date</div>
          <div className="border-b">{data.birth_date}</div>
          <div className="border-b font-semibold">Address</div>
          <div className="border-b">{data.address}</div>
          <div className="border-b font-semibold">Hired date</div>
          <div className="border-b">{data.hired_date}</div>
          <div className="border-b font-semibold">Department</div>
          <div className="border-b">{data.department}</div>
          <div className="border-b font-semibold">Position</div>
          <div className="border-b">{data.position}</div>
          <div className="border-b font-semibold">Gender</div>
          <div className="border-b">{data.sex}</div>
          <div className="border-b font-semibold">Civil status</div>
          <div className="border-b">{data.civil_status}</div>
        </div>
      </div>
    </MainLayout>
  );
}
