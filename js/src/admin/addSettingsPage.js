import { extend } from 'flarum/extend';
import AdminNav from 'flarum/components/AdminNav';
import AdminLinkButton from 'flarum/components/AdminLinkButton';
import SettingsPage from './components/SettingsPage';

export default function () {
    app.routes['fof-doorman'] = {
        path: '/fof/doorman',
        component: SettingsPage,
    };

    app.extensionSettings['fof-doorman'] = () => m.route.set(app.route('fof-doorman'));

    extend(AdminNav.prototype, 'items', (items) => {
        items.add(
            'fof-doorman',
            AdminLinkButton.component(
                {
                    href: app.route('fof-doorman'),
                    icon: 'fa fa-door-closed',
                    description: app.translator.trans('fof-doorman.admin.nav.desc'),
                },
                'Doorman'
            )
        );
    });
}
