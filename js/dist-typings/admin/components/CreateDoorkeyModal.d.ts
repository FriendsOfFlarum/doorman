/// <reference types="flarum/@types/translator-icu-rich" />
import Modal, { IInternalModalAttrs } from 'flarum/common/components/Modal';
import ItemList from 'flarum/common/utils/ItemList';
import Stream from 'flarum/common/utils/Stream';
import type Mithril from 'mithril';
export interface ICreateDoorkeyModalAttrs extends IInternalModalAttrs {
    key?: string;
    groupId?: string;
    maxUses?: number;
    activates?: boolean;
}
export type SignupBody = {
    key: string;
    groupId: string;
    maxUses: number;
    activates: boolean;
};
export default class CreateDoorkeyModal<CustomAttrs extends ICreateDoorkeyModalAttrs = ICreateDoorkeyModalAttrs> extends Modal<CustomAttrs> {
    key: Stream<string>;
    groupId: Stream<number>;
    maxUses: Stream<number>;
    activates: Stream<boolean>;
    /**
     * Keeps the modal open after the doorkey is created to facilitate creating
     * multiple doorkeys at once.
     */
    bulkAdd: Stream<boolean>;
    oninit(vnode: Mithril.Vnode<CustomAttrs, this>): void;
    className(): string;
    title(): import("@askvortsov/rich-icu-message-formatter").NestedStringArray;
    content(): JSX.Element;
    fields(): ItemList<Mithril.Children>;
    onready(): void;
    onsubmit(e?: SubmitEvent | null): void;
    getGroupsForInput(): {
        [key: string]: string;
    };
    generateRandomKey(): string;
    /**
     * Get the data that should be submitted in the sign-up request.
     */
    submitData(): SignupBody;
    resetData(): void;
}
