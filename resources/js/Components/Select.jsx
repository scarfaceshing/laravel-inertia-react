import { useEffect } from 'react';
import _ from 'lodash';

export default function Select({ options, handleChange }) {
  return (
    <select
      onChange={e => handleChange(e.target.value)}
      className="text-sm border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
    >
      {options.map(option => (
        <option key={option} value={option}>
          {displayValue(option)}
        </option>
      ))}
    </select>
  );
}

const trimString = value => {
  value = _.replace(value, '_', ' ');
  value = _.capitalize(value);

  return value;
};

const displayValue = value => <>{trimString(value)}</>;
