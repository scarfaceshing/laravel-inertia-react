export default function Select({ options, handleChange }) {
  return (
    <select
      onChange={e => handleChange(e.target.value)}
      className="text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
    >
      {options.map(option => (
        <option key={option} value={option}>
          {option}
        </option>
      ))}
    </select>
  );
}
