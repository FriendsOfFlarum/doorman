import Extend from 'flarum/common/extenders';
import app from 'flarum/admin/app';
import Doorkey from '../common/models/Doorkey';
import DoorkeyListPage from './components/DoorkeyListPage';

export default [
  new Extend.Store() //
    .add('doorkeys', Doorkey),

  new Extend.Admin() //
    .page(DoorkeyListPage)
    // Surface Doorman's settings in the admin global search. Items without an
    // explicit link fall back to the extension page; the group label/icon fall
    // back to the extension's composer metadata.
    .generalIndexItems('settings', () => [
      {
        id: 'fof-doorman.allowPublic',
        label: app.translator.trans('fof-doorman.admin.settings.optional_usage', {}, true),
        help: app.translator.trans('fof-doorman.admin.settings.optional_usage_help', {}, true),
      },
      {
        id: 'fof-doorman.invite-codes',
        label: app.translator.trans('fof-doorman.admin.list.heading', {}, true),
      },
      {
        id: 'fof-doorman.create-doorkey',
        label: app.translator.trans('fof-doorman.admin.settings.create_doorkey_button', {}, true),
      },
      {
        id: 'fof-doorman.send-invites',
        label: app.translator.trans('fof-doorman.admin.modals.send_invites.title', {}, true),
      },
    ]),
];
