import app from 'flarum/common/app';
import Modal, { IInternalModalAttrs } from 'flarum/common/components/Modal';
import Button from 'flarum/common/components/Button';

import ItemList from 'flarum/common/utils/ItemList';
import Stream from 'flarum/common/utils/Stream';
import Switch from 'flarum/common/components/Switch';
import Select from 'flarum/common/components/Select';
import Group from 'flarum/common/models/Group';

import type Mithril from 'mithril';
import type Doorkey from '../../common/models/Doorkey';
import type { SaveAttributes } from 'flarum/common//Model';

export interface IEditDoorkeyModalAttrs extends IInternalModalAttrs {
  doorkey: Doorkey;
}

export default class EditDoorkeyModal<CustomAttrs extends IEditDoorkeyModalAttrs = IEditDoorkeyModalAttrs> extends Modal<CustomAttrs> {
  protected key!: Stream<string>;
  protected groupId!: Stream<number>;
  protected maxUses!: Stream<number>;
  protected activates!: Stream<boolean>;

  oninit(vnode: Mithril.Vnode<CustomAttrs, this>) {
    super.oninit(vnode);

    const doorkey = this.attrs.doorkey;

    this.key = Stream(doorkey.key() || '');
    this.groupId = Stream(doorkey.groupId() || '');
    this.maxUses = Stream(doorkey.maxUses());
    this.activates = Stream(doorkey.activates() || false);
  }

  className() {
    return 'Modal--small EditDoorkeyModal';
  }

  title() {
    return app.translator.trans('fof-doorman.admin.modals.edit_doorkey.title');
  }

  content() {
    return (
      <div className="Modal-body">
        <div className="Form">{this.fields().toArray()}</div>
      </div>
    );
  }

  fields(): ItemList<Mithril.Children> {
    const items = new ItemList<Mithril.Children>();

    items.add(
      'key',
      <div className="Form-group">
        <label>{app.translator.trans('fof-doorman.admin.modals.edit_doorkey.key.label')}</label>
        <div className="helpText">{app.translator.trans('fof-doorman.admin.modals.edit_doorkey.key.help')}</div>
        <input className="FormControl" bidi={this.key} disabled={true} />
      </div>,
      100
    );

    items.add(
      'group',
      <div className="Form-group">
        <label>{app.translator.trans('fof-doorman.admin.modals.create_doorkey.group.label')}</label>
        <div className="helpText">{app.translator.trans('fof-doorman.admin.modals.create_doorkey.group.help')}</div>
        <Select
          name="groupId"
          options={this.getGroupsForInput()}
          aria-label={app.translator.trans('fof-doorman.admin.edit_doorkey_modal.group')}
          value={String(this.groupId())}
          onchange={(val: string) => this.groupId(Number(val))}
          disabled={this.loading}
        />
      </div>,
      80
    );

    items.add(
      'maxUses',
      <div className="Form-group">
        <label>{app.translator.trans('fof-doorman.admin.modals.create_doorkey.max_uses.label')}</label>
        <div className="helpText">{app.translator.trans('fof-doorman.admin.modals.create_doorkey.max_uses.help')}</div>
        <input
          className="FormControl"
          name="maxUses"
          type="number"
          aria-label={app.translator.trans('fof-doorman.admin.edit_doorkey_modal.max_uses')}
          bidi={this.maxUses}
          disabled={this.loading}
        />
      </div>,
      60
    );

    items.add(
      'activates',
      <div className="Form-group">
        <label>{app.translator.trans('fof-doorman.admin.modals.create_doorkey.activates_user.label')}</label>
        <div className="helpText">{app.translator.trans('fof-doorman.admin.modals.create_doorkey.activates_user.help')}</div>
        <Switch name="activates" state={this.activates()} onchange={(checked: boolean) => this.activates(checked)} disabled={this.loading}>
          {'‎'} {/* Zero-width space to fix unexpected UI when left empty*/}
        </Switch>
      </div>,
      40
    );

    items.add(
      'submit',
      <div className="Form-group">
        <Button className="Button Button--primary" type="submit" loading={this.loading}>
          {app.translator.trans('fof-doorman.admin.modals.edit_doorkey.submit_button')}
        </Button>
      </div>,
      -10
    );

    return items;
  }

  getGroupsForInput() {
    let options: { [key: string]: string } = {};

    app.store.all('groups').map((group) => {
      const groupCasted = group as Group;
      if (groupCasted.id() === Group.GUEST_ID) {
        return;
      }
      options[groupCasted.id() as string] = groupCasted.nameSingular();
    });

    return options;
  }

  data(): SaveAttributes {
    return {
      groupId: Number(this.groupId()),
      maxUses: Number(this.maxUses()),
      activates: this.activates(),
    };
  }

  onsubmit(e: SubmitEvent) {
    e.preventDefault();

    this.loading = true;

    this.attrs.doorkey
      .save(this.data(), { errorHandler: this.onerror.bind(this) })
      .then(this.hide.bind(this))
      .catch(() => {
        this.loading = false;
      })
      .finally(() => {
        const id = this.attrs.doorkey.id();
        if (id) {
          /**
           * Used as a workaround to update the UI because we are not properly
           * saving the group relationship here. Ideally, the relationship would
           * be saved properly in the frontend which would update the UI automatically.
           */
          app.store.find('fof/doorkeys', id);
        }
      });
  }
}
