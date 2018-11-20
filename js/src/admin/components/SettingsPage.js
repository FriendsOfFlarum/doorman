import Page from 'flarum/components/Page';
import LoadingIndicator from 'flarum/components/LoadingIndicator';
import DoormanSettingsListItem from './DoormanSettingsListItem';
import Button from 'flarum/components/Button';
import Select from 'flarum/components/Select';
import Switch from 'flarum/components/Switch';

export default class DoormanSettingsPage extends Page {
    init() {
        super.init();

        this.loading = false;
        this.doorkeys = app.store.all('doorkeys');

        this.doorkey = {
            key: m.prop(this.generateRandomKey()),
            groupId: m.prop(3),
            maxUses: m.prop(10),
            activates: m.prop(false)
        }
    }

    view() {
        return (
            <div className="container Doorkey-container">
                <h1>Doorman</h1>
                {this.loading ? (
                    <LoadingIndicator/>
                ) : ''}
                <div className="Doorkeys-title">
                    <h2>{app.translator.trans('reflar-doorman.admin.page.doorkey.title')}</h2>
                    <div className="helpText">{app.translator.trans('reflar-doorman.admin.page.doorkey.help.key')}</div>
                    <div className="helpText">{app.translator.trans('reflar-doorman.admin.page.doorkey.help.group')}</div>
                    <div className="helpText">{app.translator.trans('reflar-doorman.admin.page.doorkey.help.max')}</div>
                    <div className="helpText">{app.translator.trans('reflar-doorman.admin.page.doorkey.help.activates')}</div>
                </div>
                <div>
                    <h3 className="key">{app.translator.trans('reflar-doorman.admin.page.doorkey.heading.key')}</h3>
                    <h3 className="group">{app.translator.trans('reflar-doorman.admin.page.doorkey.heading.group')}</h3>
                    <h3 className="maxUses">{app.translator.trans('reflar-doorman.admin.page.doorkey.heading.max_uses')}</h3>
                    <h3 className="activate">{app.translator.trans('reflar-doorman.admin.page.doorkey.heading.activate')}</h3>
                </div>
                <div className="Doorkeys">
                    {this.doorkeys.map(doorkey => {
                        return DoormanSettingsListItem.component({doorkey, doorkeys: this.doorkeys})
                    })}
                </div>
                <div className="Doorkeys-new">
                    <input
                        className='FormControl Doorkey-key'
                        type='text'
                        value={this.doorkey.key()}
                        placeholder={app.translator.trans('reflar-doorman.admin.page.doorkey.key')}
                        oninput={m.withAttr('value', this.doorkey.key)}
                    />
                    {Select.component({
                        options: this.getGroupsForInput(),
                        className: 'Doorkey-select',
                        onchange: this.doorkey.groupId,
                        value: this.doorkey.groupId()
                    })}
                    <input
                        className='FormControl Doorkey-maxUses'
                        value={this.doorkey.maxUses()}
                        type='number'
                        placeholder={app.translator.trans('reflar-doorman.admin.page.doorkey.max_uses')}
                        oninput={m.withAttr('value', this.doorkey.maxUses)}
                    />
                    {Switch.component({
                        state: this.doorkey.activates() || false,
                        onchange: this.doorkey.activates,
                        className: 'Doorkey-switch'
                    })}
                    {Button.component({
                        type: 'button',
                        className: 'Button Button--warning Doorkey-button',
                        icon: 'fa fa-plus',
                        onclick: this.createDoorkey.bind(this)
                    })}
                </div>
            </div>
        );
    }

    getGroupsForInput(){
        let options = [];

        app.store.all('groups').map(group => {
            if (group.nameSingular() === 'Guest') {
                return;
            }
            options[group.id()] = group.nameSingular()
        });

        return options;
    }

    generateRandomKey() {
        return Array(8+1).join((Math.random().toString(36)+'00000000000000000').slice(2, 18)).slice(0, 8)
    }

    createDoorkey(doorkey) {
        app.store.createRecord('doorkeys').save({
            key: this.doorkey.key(),
            groupId: this.doorkey.groupId(),
            maxUses: this.doorkey.maxUses(),
            activates: this.doorkey.activates()
        }).then(
            doorkey => {
                this.doorkey.key(this.generateRandomKey());
                this.doorkey.groupId(3);
                this.doorkey.maxUses(10);
                this.doorkey.activates('');
                this.doorkeys.push(doorkey);
                m.redraw();
            }
        );
    }
}
