import _ from 'lodash';
import { ADMINISTRATOR, ALL_PERMISSIONS, ALL_ROLES, ROLES_AND_PERMISSIONS } from '@/constants';
import { useEffect, useRef } from 'react';
import { useForm } from '@inertiajs/react';
import Checkbox from '@/Components/Checkbox';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';

const Form = props => {
  const permissionCheckboxes = useRef(null);

  const { data, setData, post, put, processing, errors } = useForm({
    id: props.data.id,
    username: props.data.username,
    email: props.data.email,
    password: props.data.password,
    password_confirmation: props.data.password_confirmation,
    permission: props.data.permission,
  });

  useEffect(() => {
    if (!data.role) {
      setData('role', ADMINISTRATOR);
    }
  }, [data.role]);

  // useEffect(() => {
  //   console.log(data.permission);
  // }, [data.permission]);

  function submit(event) {
    event.preventDefault();

    if (props.data.isEdit === true) {
      put(route('users.update', props.data.id));
    } else {
      post(route('users.store'));
    }
  }

  function handleCheckPermission(checked, value) {
    if (checked === true) {
      setData('permission', [...data.permission, value]);
    } else if (checked === false) {
      let permission = _.remove(data.permission, permission => permission === value);
      setData('permission', permission);
    }
  }

  function handleCheckRole(checked, value) {
    let { permissions } = ROLES_AND_PERMISSIONS.find(item => item.name === value);

    Object.values(permissionCheckboxes).forEach(element => {
      if (element !== null && permissions.includes(element.dataset.value)) {
        element.checked = checked;
      }
    });
  }

  return (
    <form onSubmit={submit} className="grid grid-cols-1 justify-items-center items-center">
      <div className="space-y-5 w-1/2">
        <h1>Users details</h1>
        <div>
          <InputLabel htmlFor="email">
            Email<span className="text-red-500 ml-1">&#42;</span>
          </InputLabel>
          <TextInput
            id="email"
            className="w-full"
            value={data.email}
            onChange={e => setData('email', e.target.value)}
          />
          <InputError message={errors.email} />
        </div>
        <div>
          <InputLabel htmlFor="username">
            Username <span className="text-red-500 ml-1">&#42;</span>
          </InputLabel>
          <TextInput
            id="username"
            className="w-full"
            value={data.username}
            onChange={e => setData('username', e.target.value)}
          />
          <InputError message={errors.username} />
        </div>
        <div>
          <InputLabel htmlFor="password">
            Password <span className="text-red-500 ml-1">&#42;</span>
          </InputLabel>
          <TextInput
            id="password"
            type="password"
            className="w-full"
            value={data.password}
            onChange={e => setData('password', e.target.value)}
          />
          <InputError message={errors.password} />
        </div>
        <div>
          <InputLabel htmlFor="password_confirmation">
            Confirm Password <span className="text-red-500 ml-1">&#42;</span>
          </InputLabel>
          <TextInput
            id="password_confirmation"
            type="password"
            className="w-full"
            value={data.password_confirmation}
            onChange={e => setData('password_confirmation', e.target.value)}
          />
          <InputError message={errors.password} />
        </div>
        <h1>Permissions</h1>
        <div className="flex flex-wrap gap-y-2">
          {ALL_PERMISSIONS.map((permission, index) => (
            <div key={index} className="basis-1/3 flex items-center gap-x-2">
              <Checkbox
                id={`checkbox-permission-${index}`}
                ref={element => (permissionCheckboxes[index] = element)}
                data-value={`${permission}`}
                onChange={e => handleCheckPermission(e.target.checked, permission)}
              />
              <InputLabel htmlFor={`checkbox-permission-${index}`}>{permission}</InputLabel>
            </div>
          ))}
        </div>
        <h1>Roles</h1>
        <div className="flex flex-wrap gap-y-2">
          {ALL_ROLES.map((role, index) => (
            <div key={index} className="basis-1/3 flex items-center gap-x-2">
              <Checkbox id={`checkbox-role-${index}`} onChange={e => handleCheckRole(e.target.checked, role)} />
              <InputLabel htmlFor={`checkbox-role-${index}`}>{role}</InputLabel>
            </div>
          ))}
        </div>
        <div>
          <PrimaryButton type="submit">Submit</PrimaryButton>
        </div>
      </div>
    </form>
  );
};

export default Form;
