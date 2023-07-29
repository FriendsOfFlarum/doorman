import ExtensionPage from 'flarum/admin/components/ExtensionPage';
import LoadingIndicator from 'flarum/common/components/LoadingIndicator';
import DoormanSettingsListItem from './DoormanSettingsListItem';
import Button from 'flarum/common/components/Button';
import Select from 'flarum/common/components/Select';
import Switch from 'flarum/common/components/Switch';
import app from 'flarum/admin/app';
import Stream from 'flarum/common/utils/Stream';
import withAttr from 'flarum/common/utils/withAttr';

export default class DoormanSettingsPage extends ExtensionPage {
  oninit(vnode) {
    super.oninit(vnode);

    this.loadingKeys = true;
    this.isOptional = app.data.settings['fof-doorman.allowPublic'];

    this.doorkey = {
      key: Stream(this.generateRandomKey()),
      groupId: Stream(3),
      maxUses: Stream(10),
      activates: Stream(false),
    };
  }

  oncreate(vnode) {
    super.oncreate(vnode);

    app.store.find('fof/doorkeys').then(() => {
      this.loadingKeys = false;
      m.redraw();
    });
  }

  content() {
    const doorkeys = app.store.all('doorkeys');

    return (
      <div className="container Doorkey-container">
        <div className="Doorkeys-title">
          <h2>{app.translator.trans('fof-doorman.admin.page.doorkey.title')}</h2>
          <p className="helpText">
            {app.translator.trans('fof-doorman.admin.page.doorkey.help.key')} <br />
            {app.translator.trans('fof-doorman.admin.page.doorkey.help.group')} <br />
            {app.translator.trans('fof-doorman.admin.page.doorkey.help.max')} <br />
            {app.translator.trans('fof-doorman.admin.page.doorkey.help.activates')} <br />
          </p>
        </div>

        {this.loadingKeys ? (
          <LoadingIndicator />
        ) : (
          <table className="Table">
            <thead>
              <tr className="Doorkeys-fieldLabels">
                <th>{app.translator.trans('fof-doorman.admin.page.doorkey.heading.key')}</th>
                <th>{app.translator.trans('fof-doorman.admin.page.doorkey.heading.group')}</th>
                <th>{app.translator.trans('fof-doorman.admin.page.doorkey.heading.max_uses')}</th>
                <th>{app.translator.trans('fof-doorman.admin.page.doorkey.heading.activate')}</th>
              </tr>
            </thead>

            <tbody>
              {doorkeys.map((doorkey) => (
                <DoormanSettingsListItem doorkey={doorkey} doorkeys={doorkeys} />
              ))}
            </tbody>

            <tfoot>
              <tr className="Doorkeys-new">
                <td>
                  <input
                    className="FormControl Doorkey-key"
                    type="text"
                    value={this.doorkey.key()}
                    placeholder={app.translator.trans('fof-doorman.admin.page.doorkey.key')}
                    oninput={withAttr('value', this.doorkey.key)}
                    form="fof-doorkey-new"
                  />
                </td>
                <td>
                  {Select.component({
                    options: this.getGroupsForInput(),
                    className: 'Doorkey-select',
                    onchange: this.doorkey.groupId,
                    value: this.doorkey.groupId(),
                  })}
                </td>
                <td>
                  <input
                    className="FormControl Doorkey-maxUses"
                    value={this.doorkey.maxUses()}
                    type="number"
                    placeholder={app.translator.trans('fof-doorman.admin.page.doorkey.max_uses')}
                    oninput={withAttr('value', this.doorkey.maxUses)}
                    min="0"
                    form="fof-doorkey-new"
                  />
                </td>
                <td>
                  {Switch.component({
                    state: this.doorkey.activates() || false,
                    onchange: this.doorkey.activates,
                    className: 'Doorkey-switch',
                  })}
                </td>
                <td>
                  <form id="fof-doorkey-new">
                    {Button.component({
                      type: 'submit',
                      className: 'Button Button--icon Doorkey-button',
                      icon: `fa ${this.loadingCreate ? 'fa-circle-notch fa-spin' : 'fa-plus'} fa-fw`,
                      onclick: this.createDoorkey.bind(this),
                      disabled: this.loadingCreate,
                    })}
                  </form>
                </td>
              </tr>
            </tfoot>
          </table>
        )}

        <div className="Doorkey-allowPublic">
          <h2>{app.translator.trans('fof-doorman.admin.page.doorkey.allow-public.title')}</h2>
          {this.buildSettingComponent({
            type: 'boolean',
            setting: 'fof-doorman.allowPublic',
            label: app.translator.trans('fof-doorman.admin.page.doorkey.allow-public.switch-label'),
          })}

          {this.submitButton()}
        </div>
      </div>
    );
  }

  getGroupsForInput() {
    let options = [];

    app.store.all('groups').map((group) => {
      if (group.nameSingular() === 'Guest') {
        return;
      }
      options[group.id()] = group.nameSingular();
    });

    return options;
  }

  generateRandomKey() {
    return Array(8 + 1)
      .join((Math.random().toString(36) + '00000000000000000').slice(2, 18))
      .slice(0, 8);
  }

  createDoorkey(e) {
    e?.preventDefault?.();

    this.loadingCreate = true;

    app.store
      .createRecord('doorkeys')
      .save({
        key: this.doorkey.key(),
        groupId: this.doorkey.groupId(),
        maxUses: this.doorkey.maxUses(),
        activates: this.doorkey.activates(),
      })
      .then(() => {
        this.doorkey.key(this.generateRandomKey());
        this.doorkey.groupId(3);
        this.doorkey.maxUses(10);
        this.doorkey.activates('');
      })
      .finally(() => {
        this.loadingCreate = false;
        m.redraw();
      });
  }
}
