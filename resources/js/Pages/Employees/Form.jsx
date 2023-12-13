import { CIVIL_STATUS } from '@/constants';
import { useForm } from '@inertiajs/inertia-react';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import Select from '@/Components/Select';
import TextInput from '@/Components/TextInput';
import PrimaryButton from '@/Components/PrimaryButton';
import ImageUpload from '@/Components/ImageUpload';
import { useEffect } from 'react';
import { Datepicker } from 'flowbite-react';

export default function Form(props) {
  useEffect(() => console.log(props), []);

  const { data, setData, post, put, processing, errors } = useForm({
    firstName: props.data.first_name,
    middleName: props.data.middle_name,
    lastName: props.data.last_name,
    departments: props.data.departments,
    positions: props.data.positions,
    civilStatus: props.data.civil_status,
  });

  function submit(event) {
    event.preventDefault();
    console.log(data);
  }

  return (
    <form onSubmit={submit}>
      <div className="grid justify-center gap-y-6">
        <div className="grid place-items-center">
          {/* <InputLabel htmlFor="Image">
            Image<span className="text-red-500 ml-1">&#42;</span>
          </InputLabel> */}
          <ImageUpload />
        </div>
        <div>
          <InputLabel htmlFor="firstName">
            First name<span className="text-red-500 ml-1">&#42;</span>
          </InputLabel>
          <TextInput id="firstName" value={data.first_name} onChange={e => setData('firstName', e.target.value)} />
          <InputError message={errors.first_name} />
        </div>
        <div>
          <InputLabel htmlFor="middleName">
            Middle name<span className="text-red-500 ml-1">&#42;</span>
          </InputLabel>
          <TextInput id="middleName" value={data.middleName} onChange={e => setData('middleName', e.target.value)} />
          <InputError message={errors.middleName} />
        </div>
        <div>
          <InputLabel htmlFor="lastName">
            Last name<span className="text-red-500 ml-1">&#42;</span>
          </InputLabel>
          <TextInput id="lastName" value={data.lastName} onChange={e => setData('lastName', e.target.value)} />
          <InputError message={errors.lastName} />
        </div>
        <div>
          <Datepicker />
        </div>
        <div>
          <InputLabel htmlFor="department">
            Department<span className="text-red-500 ml-1">&#42;</span>
          </InputLabel>
          <Select
            id="department"
            className="w-full text-sm rounded-md shadow-sm"
            handleChange={value => setData('departments', value)}
            options={props.lookups.departments}
            modifyText={['no_underscore', 'capitalize']}
          />
        </div>
        <div>
          <InputLabel htmlFor="position">
            Position<span className="text-red-500 ml-1">&#42;</span>
          </InputLabel>
          <Select
            id="position"
            className="w-full text-sm rounded-md shadow-sm"
            handleChange={value => setData('positions', value)}
            options={props.lookups.positions}
            modifyText={['no_underscore']}
          />
        </div>
        <div>
          <InputLabel htmlFor="gender">
            Gender<span className="text-red-500 ml-1">&#42;</span>
          </InputLabel>
          <div className="grid grid-cols-2 pt-2 gap-y-2">
            <div>
              <input
                id="gender-male"
                type="radio"
                name="gender"
                className="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
              />
              <label
                htmlFor="gender-male"
                className="w-full py-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
              >
                Male
              </label>
            </div>
            <div>
              <input
                id="gender-female"
                type="radio"
                name="gender"
                className="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
              />
              <label
                htmlFor="gender-female"
                className="w-full py-4 ml-2 text-sm font-medium text-gray-900 dark:text-gray-300"
              >
                Female
              </label>
            </div>
          </div>
        </div>
        <div>
          <InputLabel htmlFor="civilStatus">
            Civil status<span className="text-red-500 ml-1">&#42;</span>
          </InputLabel>
          <Select
            id="position"
            className="w-full text-sm rounded-md shadow-sm"
            handleChange={value => setData('civilStatus', value)}
            options={CIVIL_STATUS}
            modifyText={['no_underscore', 'capitalize']}
          />
        </div>
        <div>
          <PrimaryButton>Submit</PrimaryButton>
        </div>
      </div>
    </form>
  );
}
