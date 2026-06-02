import { IFormModalAttrs } from 'flarum/common/components/FormModal';
import FormModal from 'flarum/common/components/FormModal';
import Stream from 'flarum/common/utils/Stream';
import type Doorkey from '../../common/models/Doorkey';
import type Mithril from 'mithril';
export interface IInviteCodeModalAttrs extends IFormModalAttrs {
    doorkey: Doorkey;
}
export default class InviteCodeModal<CustomAttrs extends IInviteCodeModalAttrs = IInviteCodeModalAttrs> extends FormModal<CustomAttrs> {
    protected doorkey: Doorkey;
    /**
     * Addresses queued to receive an invite.
     */
    protected emails: string[];
    /**
     * The current value of the email input (not yet committed to {@link emails}).
     */
    protected input: Stream<string>;
    protected badEmails: string[];
    protected alert: number | undefined;
    oninit(vnode: Mithril.Vnode<CustomAttrs, this>): void;
    className(): string;
    title(): string | any[];
    onremove(vnode: Mithril.VnodeDOM<CustomAttrs, this>): void;
    content(): JSX.Element;
    /**
     * The send button is enabled when at least one address is queued, or the
     * input currently holds a valid (not-yet-committed) address.
     */
    hasSendableEmails(): boolean;
    /**
     * Move valid addresses from the input into the queued {@link emails} list.
     */
    addEmails(): void;
    validateEmail(email: string): boolean;
    removeEmail(index: number): void;
    onsubmit(e: SubmitEvent): void;
}
