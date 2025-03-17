import Model from 'flarum/common/Model';
import type Group from 'flarum/common/models/Group';
export default class Doorkey extends Model {
    key(): string;
    groupId(): number;
    group(): false | Group;
    maxUses(): number;
    activates(): boolean;
    uses(): number;
    protected apiEndpoint(): string;
}
