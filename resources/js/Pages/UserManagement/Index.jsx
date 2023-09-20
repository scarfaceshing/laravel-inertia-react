import MainLayout from '@/Layouts/MainLayout';
import DynamicTable from '@/Components/DynamicTable';
import { Head, router } from '@inertiajs/react';
import { useEffect, useRef } from 'react';

export default function UserManagement(props) {
    
    useEffect(() => {
        // router.visit(`${route().current()}`, { search: 'John' }, { preserveState: true });
    });

    const test = [
        {
            column: 'username',
            name: 'Username',
        },
        {
            column: 'name',
            name: 'Name',
        },
        {
            column: 'email',
            name: 'Email'
        },
        {
            column: 'email_verified_at',
            name: 'Verified at'
        },
        {
            column: 'created_at',
            name: 'Created at'
        }
    ];

    return (
        <MainLayout
            auth={props.auth}
            errors={props.errors}
        >
            <Head title="User Management" />
            <div>
                <div>
                    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <h1 className="text-3xl p-6 text-gray-900">User Management</h1>
                    </div>
                </div>
                <div>
                    <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                        <div className="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                            <DynamicTable data={props.users} columns={test} />
                        </div>
                    </div>
                </div>
            </div>
        </MainLayout>
    );
}
