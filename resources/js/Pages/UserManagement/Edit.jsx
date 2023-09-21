import { Head } from '@inertiajs/react';
import MainLayout from '@/Layouts/MainLayout';

export default function Edit(props) {
  <MainLayout auth={props.auth} errors={props.errors}>
    <Head title="User Management Edit" />
    <div>{JSON.stringify(props.user)}</div>
  </MainLayout>;
}
