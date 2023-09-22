import MainLayout from '@/Layouts/MainLayout';
import { Head } from '@inertiajs/react';

export default function Create(props) {
  return (
    <MainLayout auth={props.auth} errors={props.errors}>
      <Head title="User Management" />

      <div className="grid grid-rows-2 gap-y-5">
        <div>
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900">Create</div>
          </div>
        </div>
        <div>
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg"></div>
        </div>
      </div>
    </MainLayout>
  );
}
