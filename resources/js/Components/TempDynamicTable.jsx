import { useRef, useState, useContext, createContext, useEffect } from 'react';
import BasicButton from '@/Components/BasicButton';
import { CaretLeft, CaretRight } from '@/icons';

/**
 * TODO: remove emit method and change to event listener and http request data should inside the component
 */

/**
 * @param data object // response backend data.
 * @param column array // table column.
 * @param sortColumn function(sortBy, orderBy) // call back function to sort columns.
 * @param totalPages integer // for displaying total pages.
 * @param fromPage integer // for displaying from page.
 * @param toPage integer // for displaying to page.
 * @param links string // for displaying http link every click pages.
 * @param pageAction function // callback function for previous and next.
 *
 * @return JSX.element // <DynamicTable />
 */
const ASCENDING = 'ASC';
const DESCENDING = 'DESC';

const DataContext = createContext();

const TempDynamicTable = ({ className = '', ...props }) => {
  const [state, setState] = useState({
    data: props.data,
    columns: props.columns,
  });

  useEffect(() => {
    setState({ ...state, data: props.data });
  }, [props.data]);

  return <DataContext.Provider value={state}>{props.children}</DataContext.Provider>;
};

const TableComponent = ({ sortColumn }) => {
  const { data, columns } = useContext(DataContext);
  const [orderBy, setOrderBy] = useState(ASCENDING);

  function orderColumn(column, indexRow, sort = true) {
    setOrderBy(orderBy === ASCENDING ? DESCENDING : ASCENDING);
    sortColumn(column, orderBy, sort);
  }

  useEffect(() => {});

  return (
    <>
      <table className="w-full text-sm text-left text-gray-500 dark:text-gray-400">
        <thead className="text-base text-white bg-gray-500 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            {columns &&
              columns.map(({ column, name, sort }, indexRow) => (
                <th key={indexRow} onClick={() => orderColumn(column, indexRow, sort)} className="py-3 text-left pl-3">
                  <div className="flex space-x-1">
                    <span>{name}</span>
                  </div>
                </th>
              ))}
          </tr>
        </thead>
        <tbody>
          {data.map((dataRow, indexRow) => (
            <tr key={indexRow} className="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
              {columns.map(({ column, mutate }, columnIndex) => (
                <td key={columnIndex} className="py-3 text-base text-left pl-3">
                  <TableDataComponent mutate={mutate} dataColumn={column} dataRow={dataRow} indexRow={indexRow} />
                </td>
              ))}
            </tr>
          ))}
        </tbody>
      </table>
    </>
  );
};

export const TableHeader = ({ children }) => <div>{children}</div>;

// const toggleShow = (element, indexRow, lastIndex) => {
//   if (indexRow === lastIndex) {
//     let newElmentClass = element.current[indexRow].classList;
//     newElmentClass.toggle('hidden');
//   }
// };

const TableDataComponent = ({ mutate, dataColumn, dataRow, indexRow }) => {
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

const Pagination = ({ currentPage, pageAction, links = {} }) => {
  function handleClick(item) {
    pageAction(item);
  }

  return (
    <div className="flex space-x-2">
      <nav aria-label="Page navigation example">
        <ul className="flex items-center -space-x-px h-8 text-sm">
          {links.map((item, index) => (
            <li key={index}>
              <BasicButton
                disabled={item.label === '...' ? true : false}
                onClick={() => handleClick(item)}
                className={`${
                  item.active ? 'text-blue-500 bg-blue-100' : 'text-gray-500'
                } flex items-center justify-center px-3 h-8 leading-tight bg-white hover:text-gray-700 dark:hover:bg-gray-700 dark:hover:text-white border dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400  border-gray-300 hover:bg-gray-100`}
              >
                <PaginateButton label={item.label} />
              </BasicButton>
            </li>
          ))}
        </ul>
      </nav>
    </div>
  );
};

const PaginateButton = ({ label }) => {
  if (label === '&laquo; Previous') {
    return <CaretLeft />;
  } else if (label === 'Next &raquo;') {
    return <CaretRight />;
  } else {
    return label;
  }
};

TempDynamicTable.TableComponent = TableComponent;

export default TempDynamicTable;
