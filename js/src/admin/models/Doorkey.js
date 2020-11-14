import Model from 'flarum/Model';
import mixin from 'flarum/utils/mixin';

export default class Doorkey extends mixin(Model, {
    id: Model.attribute('id'),
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
