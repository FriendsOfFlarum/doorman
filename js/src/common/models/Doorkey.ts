import Model from 'flarum/common/Model';
import type Group from 'flarum/common/models/Group';

export default class Doorkey extends Model {
  key() {
    return Model.attribute<string>('key').call(this);
  }

  groupId() {
    return Model.attribute<number>('groupId').call(this);
  }

  group() {
    return Model.hasOne<Group>('group').call(this);
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

  protected apiEndpoint() {
    return '/fof/doorkeys' + (this.exists ? `/${(this.data as any).id}` : '');
  }
}
