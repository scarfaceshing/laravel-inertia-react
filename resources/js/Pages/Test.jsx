import CloneDynamicTable from '@/Components/CloneDynamicTable';
import { useState } from 'react';

export default function Test({ className = '', ...props }) {
  const columns = [
    {
      column: '_index',
      name: '#',
      sort: false,
    },
    {
      column: 'name',
      name: 'Name',
    },
  ];

  return (
    <>
      <CloneDynamicTable url="/test" columns={columns} />
    </>
  );
}
