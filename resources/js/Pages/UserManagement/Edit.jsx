import MainLayout from '@/Layouts/MainLayout';
import { Head } from '@inertiajs/react';

export default function Edit(props) {
  <MainLayout auth={props.auth} errors={props.errors}>
    <Head title="User Management Edit" />
    <div>{JSON.stringify(props.user)}</div>
  </MainLayout>;
}
