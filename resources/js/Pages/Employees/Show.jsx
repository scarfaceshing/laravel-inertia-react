import { Head } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';

export default function Show(props) {
  const { data } = props;

  return (
    <MainLayout auth={props.auth} errors={props.errors}>
      <Head title="User Management" />
      <div className="p-2 bg-white w-full">
        <div className="w-1/4">
          <div className="grid grid-cols-2">
            <div>ID number</div>
            <div>{data.id_number}</div>
            <div>Full name</div>
            <div>
              {data.first_name} {data.middle_name} {data.last_name}
            </div>
            <div>Birth date</div>
            <div>{data.birth_date}</div>
            <div>Address</div>
            <div>{data.address}</div>
            <div>Hired date</div>
            <div>{data.hired_date}</div>
            <div>Department</div>
            <div>{data.department}</div>
            <div>Position</div>
            <div>{data.position}</div>
            <div>Gender</div>
            <div>{data.sex}</div>
            <div>Civil status</div>
            <div>{data.civil_status}</div>
          </div>
        </div>
      </div>
    </MainLayout>
  );
}
