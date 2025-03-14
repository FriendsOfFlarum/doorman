import Extend from 'flarum/common/extenders';
import Doorkey from '../common/models/Doorkey';

export default [
  new Extend.Store() //
    .add('doorkeys', Doorkey),
];
