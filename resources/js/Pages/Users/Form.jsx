import _, { set } from 'lodash';
import { ADMINISTRATOR, ALL_PERMISSIONS, ALL_ROLES, ROLES_AND_PERMISSIONS } from '@/constants';
import { useEffect, useRef, useState } from 'react';
import { useForm } from '@inertiajs/react';
import Checkbox from '@/Components/Checkbox';
import Switch from '@/Components/Switch';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';

const Form = props => {
  const activeRadiobox = useRef();
  const refCheckbox = useRef([]);
  const [permissions, setPermissions] = useState({});
  const [roles, setRoles] = useState({});

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

  useEffect(() => {
    if (data.is_edit) {
      let collectionPermissions = {};
      let collectionRoles = {};

      data.permissions.forEach((item, index) => {
        collectionPermissions[item] = true;
      });

      data.roles.forEach((item, index) => {
        collectionRoles[item] = true;
      });

      setPermissions({
        ...permissions,
        ...collectionPermissions,
      });

      setRoles({
        ...roles,
        ...collectionRoles,
      });
    }
  }, []);

  function submit(event) {
    event.preventDefault();

    data.roles = Object.keys(roles).map(key => {
      if (roles[key] === true) {
        return key;
      }
    });

    data.permissions = Object.keys(permissions).map(key => {
      if (permissions[key] === true) {
        return key;
      }
    });

    if (props.data.is_edit === true) {
      put(route('users.update', props.data.id));
    } else {
      post(route('users.store'));
    }
  }

  function handleCheckbox(event, type) {
    let checked = event.target.type === 'checkbox' ? event.target.checked : event.target.value;
    if (type === 'permission') {
      let permissionName = event.target.name;

      setPermissions({
        ...permissions,
        [permissionName]: checked,
      });
    } else if (type === 'role') {
      let roleName = event.target.name;
      let permissionsOfRole = ROLES_AND_PERMISSIONS.filter(role => role.name === roleName);
      let collectionPermissions = {};

      permissionsOfRole[0].permissions.forEach((item, index) => {
        collectionPermissions[item] = checked;
      });

      setPermissions({
        ...permissions,
        ...collectionPermissions,
      });

      setRoles({
        ...roles,
        [event.target.name]: checked,
      });
    }
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
            <div key={index} className="basis-1/2 flex items-center gap-x-2">
              <Checkbox
                name={`${permission}`}
                type="checkbox"
                checked={permissions[permission] === true}
                onChange={event => handleCheckbox(event, 'permission')}
              />
              <InputLabel htmlFor={`permission-${index}`}>{permission}</InputLabel>
            </div>
          ))}
        </div>
        <h1>Roles</h1>
        <div className="flex flex-wrap gap-y-2">
          {ALL_ROLES.map((role, index) => (
            <div key={index} className="basis-1/3 flex items-center gap-x-2">
              <Checkbox
                type="checkbox"
                name={`${role}`}
                checked={roles[role] === true}
                onChange={event => handleCheckbox(event, 'role')}
              />
              <InputLabel htmlFor={`roles-${index}`}>{role}</InputLabel>
            </div>
          ))}
        </div>
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
