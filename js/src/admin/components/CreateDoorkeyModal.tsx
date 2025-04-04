import app from 'flarum/admin/app';
import Modal, { IInternalModalAttrs } from 'flarum/common/components/Modal';
import Button from 'flarum/common/components/Button';
import ItemList from 'flarum/common/utils/ItemList';
import Stream from 'flarum/common/utils/Stream';
import Switch from 'flarum/common/components/Switch';
import Select from 'flarum/common/components/Select';

import Group from 'flarum/common/models/Group';
import type Mithril from 'mithril';

export interface ICreateDoorkeyModalAttrs extends IInternalModalAttrs {
  key?: string;
  groupId?: string;
  maxUses?: number;
  activates?: boolean;
}

export type SignupBody = {
  key: string;
  groupId: string;
  maxUses: number;
  activates: boolean;
};

export default class CreateDoorkeyModal<CustomAttrs extends ICreateDoorkeyModalAttrs = ICreateDoorkeyModalAttrs> extends Modal<CustomAttrs> {
  key!: Stream<string>;
  groupId!: Stream<number>;
  maxUses!: Stream<number>;
  activates!: Stream<boolean>;

  /**
   * Keeps the modal open after the doorkey is created to facilitate creating
   * multiple doorkeys at once.
   */
  bulkAdd!: Stream<boolean>;

  oninit(vnode: Mithril.Vnode<CustomAttrs, this>) {
    super.oninit(vnode);

    this.key = Stream(this.generateRandomKey());
    this.groupId = Stream(3);
    this.maxUses = Stream(10);
    this.activates = Stream(false);
    this.bulkAdd = Stream(false);
  }

  className() {
    return 'Modal--small CreateDoorkeyModal';
  }

  title() {
    return app.translator.trans('fof-doorman.admin.modals.create_doorkey.title');
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
        <label>{app.translator.trans('fof-doorman.admin.modals.create_doorkey.key.label')}</label>
        <div className="helpText">{app.translator.trans('fof-doorman.admin.modals.create_doorkey.key.help')}</div>
        <input className="FormControl" name="key" type="text" bidi={this.key} disabled={this.loading} />
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
        <input className="FormControl" name="maxUses" type="number" bidi={this.maxUses} disabled={this.loading} />
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
        <Button className="Button Button--primary Button--block" type="submit" loading={this.loading}>
          {app.translator.trans('fof-doorman.admin.modals.create_doorkey.submit_button')}
        </Button>
      </div>,
      0
    );

    items.add(
      'submitAndAdd',
      <div className="Form-group">
        <Button className="Button Button--block" onclick={() => this.bulkAdd(true) && this.onsubmit()} disabled={this.loading}>
          {app.translator.trans('fof-doorman.admin.modals.create_doorkey.submit_and_create_another_button')}
        </Button>
      </div>,
      -20
    );

    return items;
  }

  onready() {
    this.$('[name=key]').trigger('select');
  }

  onsubmit(e: SubmitEvent | null = null) {
    e?.preventDefault();

    this.loading = true;

    app
      .request({
        url: app.forum.attribute('apiUrl') + '/fof/doorkeys',
        method: 'POST',
        body: { data: { attributes: this.submitData() } },
        errorHandler: this.onerror.bind(this),
      })
      .then(() => {
        if (this.bulkAdd()) {
          this.resetData();
        } else {
          this.hide();
        }
      })
      .finally(() => {
        this.bulkAdd(false);
        this.loaded();
      });
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

  generateRandomKey() {
    return Array(8 + 1)
      .join((Math.random().toString(36) + '00000000000000000').slice(2, 18))
      .slice(0, 8);
  }

  /**
   * Get the data that should be submitted in the sign-up request.
   */
  submitData(): SignupBody {
    const data = {
      key: this.key(),
      groupId: this.groupId(),
      maxUses: this.maxUses(),
      activates: this.activates(),
    };

    return data;
  }

  resetData() {
    this.key(this.generateRandomKey());
    this.groupId(3);
    this.maxUses(10);
  }
}
