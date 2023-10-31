import Table from '@/Pages/Test/Table';
import Sidebar from '@/Pages/Test/Sidebar';

window.Echo.channel(`my-channel`).listen('.my-event', e => {
  console.log(e);
});

export default function Index(props) {
  return <Sidebar />;
}
