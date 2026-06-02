export default class InviteCodeModal extends FormModal<import("flarum/common/components/FormModal").IFormModalAttrs, undefined> {
    constructor();
    oninit(vnode: any): void;
    emails: any[] | undefined;
    doorkey: any;
    success: boolean | undefined;
    title(): string | any[];
    oncreate(vnode: any): void;
    onremove(vnode: any): void;
    content(): JSX.Element;
    addEmails(): void;
    badEmails: any[] | undefined;
    alert: number | undefined;
    validateEmail(email: any): boolean;
    removeEmail(i: any): void;
    send(e: any): void;
}
import FormModal from "flarum/common/components/FormModal";
