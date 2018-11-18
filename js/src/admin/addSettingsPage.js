import { extend } from 'flarum/extend';
import AdminNav from 'flarum/components/AdminNav';
import AdminLinkButton from 'flarum/components/AdminLinkButton';
import SettingsPage from './components/SettingsPage';

export default function() {
    app.routes['reflar-doorman'] = {
        path: '/reflar/doorman',
        component: SettingsPage.component(),
    };

    app.extensionSettings['reflar-doorman'] = () => m.route(app.route('reflar-doorman'));

    extend(AdminNav.prototype, 'items', items => {
        items.add(
            'reflar-doorman',
            AdminLinkButton.component({
                href: app.route('reflar-doorman'),
                icon: 'fa fa-door-closed',
                children: 'Doorman',
                description: app.translator.trans('reflar-doorman.admin.nav.desc'),
            })
        );
    });
}
