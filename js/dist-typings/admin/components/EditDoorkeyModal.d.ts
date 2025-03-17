/// <reference types="flarum/@types/translator-icu-rich" />
import Modal, { IInternalModalAttrs } from 'flarum/common/components/Modal';
import ItemList from 'flarum/common/utils/ItemList';
import Stream from 'flarum/common/utils/Stream';
import type Mithril from 'mithril';
import type Doorkey from '../../common/models/Doorkey';
import type { SaveAttributes } from 'flarum/common//Model';
export interface IEditDoorkeyModalAttrs extends IInternalModalAttrs {
    doorkey: Doorkey;
}
export default class EditDoorkeyModal<CustomAttrs extends IEditDoorkeyModalAttrs = IEditDoorkeyModalAttrs> extends Modal<CustomAttrs> {
    protected key: Stream<string>;
    protected groupId: Stream<number>;
    protected maxUses: Stream<number>;
    protected activates: Stream<boolean>;
    oninit(vnode: Mithril.Vnode<CustomAttrs, this>): void;
    className(): string;
    title(): import("@askvortsov/rich-icu-message-formatter").NestedStringArray;
    content(): JSX.Element;
    fields(): ItemList<Mithril.Children>;
    getGroupsForInput(): {
        [key: string]: string;
    };
    data(): SaveAttributes;
    onsubmit(e: SubmitEvent): void;
}
