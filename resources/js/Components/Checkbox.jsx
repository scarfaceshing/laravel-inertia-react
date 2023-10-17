import { forwardRef, useRef } from 'react';

export default forwardRef(function Checkbox({ type = 'text', className = '', ...props }, ref) {
  const checkbox = ref ? ref : useRef();

  return (
    <input
      {...props}
      type="checkbox"
      className={'rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 ' + className}
      ref={checkbox}
    />
  );
});
