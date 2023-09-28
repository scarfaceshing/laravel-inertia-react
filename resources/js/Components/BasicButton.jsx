export default function BasicButton({ className = '', disabled, children, ...props }) {
  return (
    <button {...props} className={`${disabled && 'opacity-80'} ` + className} disabled={disabled}>
      {children}
    </button>
  );
}
