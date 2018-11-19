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
            key: m.prop(Array(8+1).join((Math.random().toString(36)+'00000000000000000').slice(2, 18)).slice(0, 8)),
            groupId: m.prop(3),
            maxUses: m.prop(10),
            activates: m.prop(false)
        }
    }

    view() {
        const title = app.translator.trans('reflar-doorman.admin.page.title');

        return (
            <div className="container">
                <h2>{title}</h2>
                {this.loading ? (
                    <LoadingIndicator/>
                ) : ''}
                <div className="doorkeys">
                    {this.doorkeys.map(doorkey => {
                        return DoormanSettingsListItem.component({doorkey})
                    })}
                </div>
                <div style="float: left;">
                    <input
                        className='FormControl Doorkey-key'
                        type='number'
                        value={this.doorkey.key()}
                        placeholder={app.translator.trans('reflar-doorman.admin.page.doorkey.key')}
                        oninput={m.withAttr('value', this.doorkey.key)}
                    />
                    {Select.component({
                        options: this.getGroupsForInput(),
                        onchange: m.withAttr('value', this.doorkey.groupId),
                        value: this.doorkey.groupId()
                    })}
                    <input
                        className='FormControl Doorkey-maxUses'
                        value={this.doorkey.maxUses()}
                        placeholder={app.translator.trans('reflar-doorman.admin.page.doorkey.max_uses')}
                        oninput={m.withAttr('value', this.doorkey.maxUses)}
                    />
                    {Switch.component({
                        state: this.doorkey.activates() || false,
                        children: app.translator.trans('reflar-doorman.admin.page.doorkey.switch'),
                        onchange: this.doorkey.activates,
                        className: 'Doorkey-switch'
                    })}
                    {Button.component({
                        type: 'button',
                        className: 'Button Button--warning doorkey-button',
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

    createDoorkey(doorkey) {
        app.store.createRecord('doorkeys').save({
            key: this.doorkey.key(),
            groupId: this.doorkey.groupId(),
            maxUses: this.doorkey.maxUses(),
            activates: this.doorkey.activates()
        }).then(
            doorkey => {
                this.doorkey.key('');
                this.doorkey.groupId('');
                this.doorkey.maxUses('');
                this.doorkey.activates('');
                this.doorkeys.push(doorkey);
                m.redraw();
            }
        );
    }
}
