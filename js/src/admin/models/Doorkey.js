import Model from 'flarum/common/Model';
import mixin from 'flarum/common/utils/mixin';

export default class Doorkey extends mixin(Model, {
  key: Model.attribute('key'),
  groupId: Model.attribute('groupId'),
  maxUses: Model.attribute('maxUses'),
  uses: Model.attribute('uses'),
  activates: Model.attribute('activates'),
}) {
  apiEndpoint() {
    return `/fof/doorkeys${this.exists ? `/${this.data.id}` : ''}`;
  }
}
