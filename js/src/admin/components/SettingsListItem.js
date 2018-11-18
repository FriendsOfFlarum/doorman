import Component from 'flarum/Component';

export default class SettingsListItem extends Component {
    init() {
        this.doorkey = this.props.doorkey;

        this.key = m.prop(this.doorkey.key());
        this.groupId = m.prop(this.doorkey.groupId());
        this.maxUses = m.prop(this.doorkey.maxUses());
    }

    view() {
        const doorkey = this.doorkey;

        return <div className="Doorkeys--Row" />;
    }
}
