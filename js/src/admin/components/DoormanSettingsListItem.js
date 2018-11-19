import Component from 'flarum/Component';
import Button from 'flarum/components/Button';
import Select from 'flarum/components/Select';
import Switch from 'flarum/components/Switch';

export default class DoormanSettingsListItem extends Component {

    view() {
        this.doorkey = this.props.doorkey;

        return (
            <div style="float: left;">
                <input
                    className='FormControl Doorkey-key'
                    type='text'
                    value={this.doorkey.key()}
                    placeholder={app.translator.trans('reflar-doorman.admin.page.doorkey.key')}
                    onInput={m.withAttr('value', this.updateKey.bind(this, this.doorkey))}
                />
                {Select.component({
                    options: this.getGroupsForInput(),
                    onchange: this.updateGroupId.bind(this, this.doorkey),
                    value: this.doorkey.groupId() || 3
                })}
                <input
                    className='FormControl Doorkey-maxUses'
                    value={this.doorkey.maxUses()}
                    type='number'
                    placeholder={app.translator.trans('reflar-doorman.admin.page.doorkey.max_uses')}
                    onInput={m.withAttr('value', this.updateMaxUses.bind(this, this.doorkey))}
                />
                {Switch.component({
                    state: this.doorkey.activates() || false,
                    children: app.translator.trans('reflar-doorman.admin.page.doorkey.switch'),
                    onchange: this.updateActivates.bind(this, this.doorkey),
                    className: 'Doorkey-switch'
                })}
                {Button.component({
                    type: 'button',
                    className: 'Button Button--warning doorkey-button',
                    icon: 'fa fa-times',
                    onclick: this.deleteDoorkey.bind(this, this.doorkey)
                })}
            </div>
        )
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

    updateKey(doorkey, key) {
        doorkey.save({key});
    }

    updateGroupId(doorkey, groupId) {
        doorkey.save({groupId});
    }

    updateMaxUses(doorkey, maxUses) {
        doorkey.save({maxUses})
    }

    updateActivates(doorkey, activates) {
        doorkey.save({activates})
    }

    deleteDoorkey(doorkeyToDelete) {
        doorkeyToDelete.delete()
        this.doorkeys.some((doorkey, i) => {
            if (doorkey.data.id === doorkeyToDelete.data.id) {
                this.doorkey.splice(i, 1);
                return true;
            }
        })
    }
}
