import _ from 'lodash';
import { ADMINISTRATOR, ALL_PERMISSIONS, ALL_ROLES, ROLES_AND_PERMISSIONS } from '@/constants';
import { useEffect, useRef } from 'react';
import { useForm } from '@inertiajs/react';
import Checkbox from '@/Components/Checkbox';
import Switch from '@/Components/Switch';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';

const Form = props => {
  const activeRadiobox = useRef();

  const { data, setData, post, put, processing, errors } = useForm({
    id: props.data.id,
    username: props.data.username,
    email: props.data.email,
    password: props.data.password,
    password_confirmation: props.data.password_confirmation,
    permissions: props.data.permissions,
    roles: props.data.roles,
    is_edit: props.data.is_edit,
    is_active: props.data.is_active,
  });

  // useEffect(() => {
  //   if (data.is_edit) {
  //     data.roles.forEach(role => {
  //       setData('roles', role);
  //       handleCheckRole(true, role);
  //       Object.values(rolesCheckboxes).find(checkbox => checkbox && checkbox.dataset.value === role).checked = true;
  //     });

  //     data.permissions.forEach(permission => {
  //       setData('permissions', permission);
  //       handleCheckPermission(true, permission);
  //       Object.values(permissionCheckboxes).find(
  //         checkbox => checkbox && checkbox.dataset.value === permission
  //       ).checked = true;
  //     });

  //     activeRadiobox.current.checked = data.is_active;
  //   }
  // }, []);

  function submit(event) {
    event.preventDefault();

    if (props.data.is_edit === true) {
      put(route('users.update', props.data.id));
    } else {
      post(route('users.store'));
    }
  }

  // function handleCheckPermission(checked, value) {
  //   if (checked === true) {
  //     setData('permissions', [...data.permissions, value]);
  //   } else if (checked === false) {
  //     let permissions = data.permissions.filter(permission => permission !== value);
  //     setData('permissions', permissions);
  //   }
  // }

  // function handleCheckRole(checked, value) {
  //   let { permissions } = ROLES_AND_PERMISSIONS.find(item => item.name === value);
  //   Object.values(permissionCheckboxes).forEach(element => {
  //     if (element !== null && permissions.includes(element.dataset.value)) {
  //       element.checked = checked;
  //     }
  //   });

  //   if (checked === true) {
  //     setData('roles', [...data.roles, value]);
  //   } else if (checked === false) {
  //     let roles = data.roles.filter(role => role !== value);
  //     setData('roles', roles);
  //   }
  // }

  useEffect(() => {
    console.log(data.permissions);
  }, [data.permissions]);

  function handleCheckbox(type, key, checked) {
    if (checked === true) {
      // setData('permissions');
    }
    // console.log('target', data.permissions);
    // console.log(type, key, checked);
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
              <input
                id={`permission-${index}`}
                type="checkbox"
                onChange={event => handleCheckbox('permission', permission, event.target.checked)}
              />
              <InputLabel htmlFor={`permission-${index}`}>{permission}</InputLabel>
            </div>
          ))}
        </div>
        <h1>Roles</h1>
        <div className="flex flex-wrap gap-y-2">
          {ALL_ROLES.map((role, index) => (
            <div key={index} className="basis-1/3 flex items-center gap-x-2">
              <input
                id={`roles-${index}`}
                type="checkbox"
                onChange={event => handleCheckbox('role', role, event.target.checked)}
              />
              <InputLabel htmlFor={`roles-${index}`}>{role}</InputLabel>
            </div>
          ))}
        </div>
        <div>{JSON.stringify(data)}</div>
        <div className="grid space-y-4">
          <h1>Active</h1>
          <Switch ref={activeRadiobox} onChange={event => setData('is_active', event.target.checked)} />
        </div>
        <div>
          <PrimaryButton type="submit">Submit</PrimaryButton>
        </div>
      </div>
    </form>
  );
};

export default Form;

{
  /* <div className="flex flex-wrap gap-y-2">
{ALL_PERMISSIONS.map((permission, index) => (
  <div key={index} className="basis-1/3 flex items-center gap-x-2">
    <h1>{permission}</h1>
  </div>
))}
</div>
<h1>Roles</h1>
<div className="flex flex-wrap gap-y-2">
{ALL_ROLES.map((role, index) => (
  <div key={index} className="basis-1/3 flex items-center gap-x-2">
    <h1>{role}</h1>
  </div>
))}
</div> */
}
