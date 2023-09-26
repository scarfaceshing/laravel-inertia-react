import { useForm } from '@inertiajs/react';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';

const Form = props => {
  const { data, setData, post, put, processing, errors } = useForm({
    id: props.data.id,
    username: props.data.username,
    email: props.data.email,
    password: props.data.password,
    password_confirmation: props.data.password_confirmation,
  });

  function submit(event) {
    event.preventDefault();

    if (props.data.isEdit === true) {
      put(route('user-management.update', props.data.id));
    } else {
      post(route('user-management.store'));
    }
  }

  return (
    <form onSubmit={submit} className="grid grid-cols-1 justify-items-center items-center">
      <div className="space-y-5 w-1/2">
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
        <div>
          <PrimaryButton type="submit">Submit</PrimaryButton>
        </div>
      </div>
    </form>
  );
};

export default Form;
