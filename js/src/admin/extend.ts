import Extend from 'flarum/common/extenders';
import Doorkey from '../common/models/Doorkey';
import DoorkeyListPage from './components/DoorkeyListPage';

export default [
  new Extend.Store() //
    .add('doorkeys', Doorkey),

  new Extend.Admin() //
    .page(DoorkeyListPage),
];
