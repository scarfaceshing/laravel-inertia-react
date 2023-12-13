import { forwardRef, useEffect, useRef, useState } from 'react';

export default forwardRef(function TextInput({ type = 'text', className = '', isFocused = false, ...props }, ref) {
  const input = ref ? ref : useRef();

  useEffect(() => {
    if (isFocused) {
      input.current.focus();
    }
  }, []);

  return (
    <div className="flex flex-col items-start">
      <textarea
        {...props}
        type={type}
        className={'focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm ' + className}
        ref={input}
      />
    </div>
  );
});
