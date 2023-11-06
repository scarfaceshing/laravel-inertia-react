import { useEffect } from 'react';
import _ from 'lodash';

export default function Select({ className, options, handleChange, modifyText = [] }) {
  function computedText(value) {
    if (modifyText.includes('no_underscore')) {
      value = _.replace(value, '_', ' ');
    }
    if (modifyText.includes('capitalize')) {
      value = _.capitalize(value);
    }

    return value;
  }

  return (
    <select onChange={e => handleChange(e.target.value)} className={className}>
      {options.map(option => (
        <option key={option} value={option}>
          {computedText(option)}
        </option>
      ))}
    </select>
  );
}
