import app from 'flarum/admin/app';
import Component from 'flarum/common/Component';
import Button from 'flarum/common/components/Button';
import Badge from 'flarum/common/components/Badge';
import Select from 'flarum/common/components/Select';
import Switch from 'flarum/common/components/Switch';
import Stream from 'flarum/common/utils/Stream';
import InviteCodeModal from './InviteCodeModal';

export default class DoormanSettingsListItem extends Component {
  oninit(vnode) {
    super.oninit(vnode);

    this.doorkey = this.attrs.doorkey;

    this.key = Stream(this.doorkey.key());
    this.groupId = Stream(this.doorkey.groupId() || 3);
    this.maxUses = Stream(this.doorkey.maxUses() || '0');
    this.activates = Stream(!!this.doorkey.activates());
  }

  view() {
    const maxUses = this.doorkey.maxUses();
    const totalUses = this.doorkey.uses();
    const remaining = maxUses - totalUses;

    const formId = `fof-doorkey-${this.doorkey.id()}`;

    return (
      <tr className="DoormanSettingsListItem">
        <td>
          <input
            className="FormControl Doorkey-key"
            type="text"
            disabled
            value={this.key()}
            placeholder={app.translator.trans('fof-doorman.admin.page.doorkey.key')}
          />
        </td>
        <td>
          {Select.component({
            options: this.getGroupsForInput(),
            className: 'Doorkey-select',
            onchange: this.groupId,
            value: this.groupId(),
          })}
        </td>
        <td>
          <input
            className="FormControl Doorkey-maxUses"
            bidi={this.maxUses}
            min="0"
            type="number"
            form={formId}
            placeholder={app.translator.trans('fof-doorman.admin.page.doorkey.max_uses')}
          />
        </td>
        <td>
          {Switch.component({
            state: this.activates(),
            onchange: this.activates,
            className: 'Doorkey-switch',
          })}
        </td>

        <td>
          {Button.component({
            type: 'button',
            className: 'Button Button--icon Doorkey-button',
            icon: 'fa fa-envelope fa-fw',
            onclick: this.showModal.bind(this),
          })}
        </td>

        <td>
          <form id={formId}>
            <div className="ButtonGroup Doorkey-button">
              {Button.component({
                type: 'submit',
                className: 'Button Button--icon',
                icon: `fas ${this.loading ? 'fa-circle-notch fa-spin' : 'fa-save'} fa-fw`,
                onclick: this.save.bind(this),
                disabled: this.loading || this.loadingDelete,
              })}

              {Button.component({
                type: 'button',
                className: 'Button Button--danger Button--icon',
                icon: `fas ${this.loadingDelete ? 'fa-circle-notch fa-spin' : 'fa-times'} fa-fw`,
                onclick: this.delete.bind(this),
                disabled: this.loadingDelete,
              })}
            </div>
          </form>
        </td>

        <td>
          {maxUses > 0 && totalUses >= maxUses ? (
            Badge.component({
              className: 'Button--icon Doorkey-badge',
              icon: 'fas fa-user-slash',
              label: app.translator.trans('fof-doorman.admin.page.doorkey.warning'),
            })
          ) : (
            <b>
              {remaining < 0
                ? app.translator.trans('fof-doorman.admin.page.doorkey.total_uses', { totalUses })
                : app.translator.trans('fof-doorman.admin.page.doorkey.used_times', { remaining })}
            </b>
          )}
        </td>
      </tr>
    );
  }

  showModal() {
    app.modal.show(InviteCodeModal, { doorkey: this.doorkey });
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

  save(e) {
    e?.preventDefault?.();

    this.loading = true;

    return this.doorkey
      .save({
        groupId: this.groupId(),
        maxUses: this.maxUses(),
        activates: this.activates(),
      })
      .finally(() => {
        this.loading = false;
        m.redraw();
      });
  }

  delete() {
    this.loadingDelete = true;

    this.doorkey.delete().finally(() => {
      this.loadingDelete = false;
      m.redraw();
    });
  }
}
