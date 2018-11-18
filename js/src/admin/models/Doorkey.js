import Model from 'flarum/Model';
import mixin from 'flarum/utils/mixin';

export default class Doorkey extends mixin(Model, {
    id: Model.attribute('id'),
    key: Model.attribute('key'),
    group: Model.hasOne('group'),
    maxUses: Model.attribute('max_uses', Boolean),
    uses: Model.attribute('uses', Boolean),

    isValid: Model.attribute('activates', Boolean),
}) {
    apiEndpoint() {
        return `/reflar/doorkeys${this.exists ? `/${this.data.id}` : ''}`;
    }
}
