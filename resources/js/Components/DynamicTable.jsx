import { useRef, useState } from 'react';
import SecondaryButton from './SecondaryButton';

export default function DynamicTable({ className = '', ...props }) {
  const [orderBy, setOrderBy] = useState('ASC');
  const caret = useRef([]);

  function orderColumn(column, indexRow, sort = true) {
    if (sort === false) return false;

    if (column === '_index') {
      return false;
    }

    if (orderBy === 'ASC') {
      setOrderBy('DESC');
    } else if (orderBy === 'DESC') {
      setOrderBy('ASC');
    }

    props.sortColumn(column, orderBy);
  }

  return (
    <div>
      <SelectLimit selectLimit={props.selectLimit} onSelectLimit={value => props.onChangeLimit(value)} />
      <table className="table-1">
        <thead>
          <tr>
            {props.columns.map(({ column, name, sort }, indexRow) => (
              <th key={indexRow} onClick={() => orderColumn(column, indexRow, sort)}>
                <div className="flex space-x-1">
                  <span>{name}</span>
                  <div ref={el => (caret.current[indexRow] = el)} className="hidden">
                    {/* {orderBy === 'ASC' ? <CarretDown /> : <CarretUp />} */}
                  </div>
                </div>
              </th>
            ))}
          </tr>
        </thead>
        <tbody>
          {props.data.map((dataRow, indexRow) => (
            <tr key={indexRow}>
              {props.columns.map(({ column, mutate }, columnIndex) => (
                <td key={columnIndex}>
                  <TableData mutate={mutate} dataColumn={column} dataRow={dataRow} indexRow={indexRow} />
                </td>
              ))}
            </tr>
          ))}
        </tbody>
      </table>
      <div className="grid justify-end">
        <div className="grid grid-cols-1 grid-rows-1">
          <div>
            <Pagenation />
          </div>
          <div className="text-right">
            <span className="text-sm text-gray-700 dark:text-gray-400">
              Showing <span className="font-semibold text-gray-900 dark:text-white">1</span> to{' '}
              <span className="font-semibold text-gray-900 dark:text-white">10</span> of{' '}
              <span className="font-semibold text-gray-900 dark:text-white">100</span> Entries
            </span>
          </div>
        </div>
      </div>
    </div>
  );
}

// const toggleShow = (element, indexRow, lastIndex) => {
//   if (indexRow === lastIndex) {
//     let newElmentClass = element.current[indexRow].classList;
//     newElmentClass.toggle('hidden');
//   }
// };

const TableData = ({ mutate, dataColumn, dataRow, indexRow }) => {
  if (dataColumn === '_index') {
    return indexRow + 1;
  } else {
    if (mutate) {
      return mutate(dataRow[dataColumn], dataRow, indexRow);
    } else {
      return dataRow[dataColumn];
    }
  }
};

const SelectLimit = ({ selectLimit, onSelectLimit }) => (
  <select onChange={e => onSelectLimit(e.target.value)}>
    {selectLimit.map(limit => (
      <option key={limit} value={limit}>
        {limit}
      </option>
    ))}
  </select>
);

const Pagenation = () => (
  <div className="flex space-x-2">
    <nav aria-label="Page navigation example">
      <ul className="flex items-center -space-x-px h-8 text-sm">
        <li>
          <a
            href="#"
            className="flex items-center justify-center px-3 h-8 ml-0 leading-tight text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
          >
            <span className="sr-only">Previous</span>
            <svg
              className="w-2.5 h-2.5"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 6 10"
            >
              <path
                stroke="currentColor"
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth="2"
                d="M5 1 1 5l4 4"
              />
            </svg>
          </a>
        </li>
        <li>
          <a
            href="#"
            className="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
          >
            1
          </a>
        </li>
        <li>
          <a
            href="#"
            className="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
          >
            2
          </a>
        </li>
        <li>
          <a
            href="#"
            aria-current="page"
            className="z-10 flex items-center justify-center px-3 h-8 leading-tight text-blue-600 border border-blue-300 bg-blue-50 hover:bg-blue-100 hover:text-blue-700 dark:border-gray-700 dark:bg-gray-700 dark:text-white"
          >
            3
          </a>
        </li>
        <li>
          <a
            href="#"
            className="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
          >
            4
          </a>
        </li>
        <li>
          <a
            href="#"
            className="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
          >
            5
          </a>
        </li>
        <li>
          <a
            href="#"
            className="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
          >
            <span className="sr-only">Next</span>
            <svg
              className="w-2.5 h-2.5"
              aria-hidden="true"
              xmlns="http://www.w3.org/2000/svg"
              fill="none"
              viewBox="0 0 6 10"
            >
              <path
                stroke="currentColor"
                strokeLinecap="round"
                strokeLinejoin="round"
                strokeWidth="2"
                d="m1 9 4-4-4-4"
              />
            </svg>
          </a>
        </li>
      </ul>
    </nav>
  </div>
);
