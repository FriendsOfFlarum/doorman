import Model from 'flarum/common/Model';
import type Group from 'flarum/common/models/Group';

export default class Doorkey extends Model {
  key() {
    return Model.attribute<string>('key').call(this);
  }

  groupId() {
    return Model.attribute<Group>('groupId').call(this);
  }

  maxUses() {
    return Model.attribute<number>('maxUses').call(this);
  }

  activates() {
    return Model.attribute<boolean>('activates').call(this);
  }

  uses() {
    return Model.attribute<number>('uses').call(this);
  }

  apiEndpoint() {
    // @ts-ignore
    return `/fof/doorkeys${this.exists ? `/${this.data.id}` : ''}`;
  }
}
