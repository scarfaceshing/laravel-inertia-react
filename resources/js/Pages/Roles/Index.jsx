import MainLayout from '@/Layouts/MainLayout';
import { Head } from '@inertiajs/react';

export default function Index(props) {
  return (
    <MainLayout auth={props.auth} errors={props.errors}>
      <Head title="Roles" />

      <div className="py-6">
        <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div className="p-6 text-gray-900">Roles</div>
          </div>
          <div></div>
        </div>
      </div>
    </MainLayout>
  );
}
