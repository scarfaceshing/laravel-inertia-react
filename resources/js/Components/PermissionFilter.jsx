import { useEffect, useState } from 'react';

export function AllowOnly({ userPermissions, permissions, children }) {
  const [show, setShow] = useState(false);

  useEffect(() => {
    const isOk = permissions.every(permission => userPermissions.includes(permission));
    setShow(isOk);
  }, [userPermissions, permissions]);

  return <div>{show && children}</div>;
}

export function AllowAny({ userPermissions, permissions, children }) {
  const [show, setShow] = useState(false);

  useEffect(() => {
    const isOk = permissions.some(permission => userPermissions.includes(permission));
    setShow(isOk);
  }, [userPermissions, permissions]);

  return <div>{show && children}</div>;
}

export function Allow({ auth, type, permissions, children }) {
  const [show, setShow] = useState(false);

  useEffect(() => {
    if (type === 'allow_only') {
      const isOk = permissions.every(permission => auth.permissions.includes(permission));
      setShow(isOk);
    } else if (type === 'allow_any') {
      const isOk = permissions.some(permission => auth.permissions.includes(permission));
      setShow(isOk);
    }
  }, [auth, permissions, type]);

  return <div>{show && children}</div>;
}
