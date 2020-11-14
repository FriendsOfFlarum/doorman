import { extend } from 'flarum/extend';
import AdminNav from 'flarum/components/AdminNav';
import AdminLinkButton from 'flarum/components/AdminLinkButton';
import SettingsPage from './components/SettingsPage';

export default function () {
    app.routes['reflar-doorman'] = {
        path: '/reflar/doorman',
        component: SettingsPage,
    };

    app.extensionSettings['reflar-doorman'] = () => m.route.get(app.route('reflar-doorman'));

    extend(AdminNav.prototype, 'items', (items) => {
        items.add(
            'reflar-doorman',
            AdminLinkButton.component(
                {
                    href: app.route('reflar-doorman'),
                    icon: 'fa fa-door-closed',
                    description: app.translator.trans('fof-doorman.admin.nav.desc'),
                },
                'Doorman'
            )
        );
    });
}
