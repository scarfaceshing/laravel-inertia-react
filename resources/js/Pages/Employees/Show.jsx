import { Head } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';

export default function Show(props) {
  return (
    <MainLayout auth={props.auth} errors={props.errors}>
      <Head title="User Management" />
      <div>{JSON.stringify(props.data)}</div>
    </MainLayout>
  );
}
