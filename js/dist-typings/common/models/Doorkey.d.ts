import Model from 'flarum/common/Model';
import type Group from 'flarum/common/models/Group';
import type User from 'flarum/common/models/User';
export default class Doorkey extends Model {
    key(): string;
    groupId(): number;
    group(): false | Group;
    maxUses(): number;
    activates(): boolean;
    uses(): number;
    createdBy(): false | User;
    protected apiEndpoint(): string;
}
