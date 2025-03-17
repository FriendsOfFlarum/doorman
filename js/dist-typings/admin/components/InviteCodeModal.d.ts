/// <reference types="flarum/@types/translator-icu-rich" />
export default class InviteCodeModal extends Modal<import("flarum/common/components/Modal").IInternalModalAttrs, undefined> {
    constructor();
    oninit(vnode: any): void;
    emails: any[] | undefined;
    doorkey: any;
    success: boolean | undefined;
    title(): import("@askvortsov/rich-icu-message-formatter").NestedStringArray;
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
import Modal from "flarum/common/components/Modal";
