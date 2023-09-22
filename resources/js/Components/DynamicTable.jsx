import { useRef, useState } from 'react';

export default function DynamicTable({ className = '', ...props }) {
  const [orderBy, setOrderBy] = useState('ASC');
  const caret = useRef([]);

  function orderColumn(column, indexRow) {
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
      <table className="table-1">
        <thead>
          <tr>
            {props.columns.map(({ column, name }, indexRow) => (
              <th key={indexRow} onClick={() => orderColumn(column, indexRow)}>
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
      return mutate(dataRow[dataColumn], indexRow);
    } else {
      return dataRow[dataColumn];
    }
  }
};
