export default function Radio({ className, handleChange, value, labelText }) {
  return (
    <>
      <input
        id="gender-male"
        type="radio"
        name="gender"
        value={value}
        onChange={e => handleChange(e.target.value)}
        className={className}
      />
      <label htmlFor="gender-male" className="w-full py-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
        {labelText}
      </label>
      .
    </>
  );
}
