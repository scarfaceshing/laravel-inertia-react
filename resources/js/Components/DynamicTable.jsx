export default function DynamicTable({ className = '', ...props }) {
  return (
    <div>
      <table className="table-1">
        <thead>
          <tr>
            <th>Index</th>
            {props.columns.map(({ name }, index) => (
              <th key={index}>{name}</th>
            ))}
          </tr>
        </thead>
        <tbody>
          {props.data.map((dataRow, index) => (
            <tr key={index}>
              <td>{index + 1}</td>
              {props.columns.map(({ column, mutate }, index) => (
                <td key={index}>
                  {mutate ? mutate(dataRow[column]) : dataRow[column]}
                </td>
              ))}
            </tr>
          ))}
        </tbody>
      </table>
    </div>
  );
}
