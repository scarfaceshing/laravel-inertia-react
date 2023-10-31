import TempDynamicTable from '@/Components/TempDynamicTable';
import { useEffect, useState } from 'react';
import { Head, router, usePage } from '@inertiajs/react';

export default function Table(props) {
  const { response } = usePage().props;

  const [search, setSearch] = useState('');
  const [limit, setLimit] = useState(10);
  const lengthMenu = [10, 50, 100];
  const [currentPage, setCurrentPage] = useState(1);
  const [totalPages, setTotalPages] = useState(null);
  const [fromPage, setFromPage] = useState(null);
  const [toPage, setToPage] = useState(null);
  const [links, setLinks] = useState([]);
  const [orderBy, setOrderBy] = useState('');
  const [sortBy, setSortBy] = useState('');

  useEffect(() => {
    router.get(
      route('test.index'),
      {
        search: search,
        limit: limit,
        sortBy: sortBy,
        orderBy: orderBy,
        page: currentPage,
      },
      {
        preserveState: true,
      }
    );
  }, [orderBy, sortBy]);

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
    {
      column: 'description',
      name: 'Description',
    },
  ];

  function sortColumn(sortBy, orderBy) {
    setOrderBy(orderBy);
    setSortBy(sortBy);
  }

  return (
    <div>
      <button type="button" onClick={() => router.post(route('test'), {})} className="bg-gray-500 p-2 m-5">
        Event
      </button>
      <TempDynamicTable data={response.data} columns={columns} lengthMenu={[10, 50, 100]}>
        <TempDynamicTable.TableComponent sortColumn={(sortBy, orderBy) => sortColumn(sortBy, orderBy)} />
      </TempDynamicTable>
    </div>
  );
}
