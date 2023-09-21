import { CarretDown } from '@/icons';
import { useRef, useState } from 'react';

export default function DynamicTable({ className = '', ...props }) {
  const [orderBy, setOrderBy] = useState('ASC');
  const caret = useRef(null);

  function orderColumn(column) {
    if (orderBy === 'ASC') {
      setOrderBy('DESC');
    } else if (orderBy === 'DESC') {
      setOrderBy('ASC');
    }

    props.sortColumn(column, orderBy);
    console.log(caret.current.classList);
  }

  return (
    <div>
      <table className="table-1">
        <thead>
          <tr>
            {props.columns.map(({ column, name }, indexRow) => (
              <th
                key={indexRow}
                onClick={() => orderColumn(column)}
                className="test"
                ref={caret}
              >
                <span>{name}</span>
              </th>
            ))}
          </tr>
        </thead>
        <tbody>
          {props.data.map((dataRow, indexRow) => (
            <tr key={indexRow}>
              {props.columns.map(({ column, mutate }, columnIndex) => (
                <td key={columnIndex}>
                  {mutate ? mutate(dataRow[column], indexRow) : dataRow[column]}
                </td>
              ))}
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
