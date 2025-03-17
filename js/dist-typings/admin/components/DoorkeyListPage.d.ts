import ExtensionPage from 'flarum/admin/components/ExtensionPage';
import ItemList from 'flarum/common/utils/ItemList';
import type { ExtensionPageAttrs } from 'flarum/admin/components/ExtensionPage';
import type Doorkey from 'src/common/models/Doorkey';
import type Mithril from 'mithril';
export type ColumnData = {
    /**
     * Column title
     */
    name: Mithril.Children;
    /**
     * Component(s) to show for this column.
     */
    content: (doorkey: Doorkey) => Mithril.Children;
};
export default class DoorkeyListPage extends ExtensionPage {
    private query;
    private throttledSearch;
    /**
     * Number of doorkeys to load per page.
     */
    private numPerPage;
    /**
     * Current page number. Zero-indexed.
     */
    private pageNumber;
    /**
     * Page number being loaded. Zero-indexed.
     */
    private loadingPageNumber;
    /**
     * Total number of doorkeys.
     *
     * Fetched from the active `AdminApplication` (`app`), with
     * data provided by `AdminPayload.php`.
     */
    readonly doorkeyCount: number;
    loadingDelete: {
        [key: string]: boolean;
    };
    /**
     * Get total number of doorkey pages.
     */
    private getTotalPageCount;
    /**
     * This page's array of doorkeys.
     *
     * `undefined` when page loads as no data has been fetched.
     */
    private pageData;
    /**
     * Are there more doorkeys available?
     */
    private moreData;
    private isLoadingPage;
    oninit(vnode: Mithril.Vnode<ExtensionPageAttrs, this>): void;
    /**
     * Component to render.
     */
    content(): JSX.Element;
    headerItems(): ItemList<Mithril.Children>;
    actionItems(): ItemList<Mithril.Children>;
    /**
     * Build an item list of columns to show for each doorkey.
     *
     * Each column in the list should be an object with keys `name` and `content`.
     *
     * `name` is a string that will be used as the column name.
     * `content` is a function with the Doorkey model passed as the first and only argument.
     *
     * See `DoorkeyListPage.tsx` for examples.
     */
    columns(): ItemList<ColumnData>;
    /**
     * Asynchronously fetch the next set of doorkeys to be rendered.
     *
     * Returns an array of doorkeys, plus the raw API payload.
     *
     * Uses the `this.numPerPage` as the response limit, and automatically calculates the offset required from `pageNumber`.
     *
     * @param pageNumber The **zero-based** page number to load and display
     */
    loadPage(pageNumber: number): Promise<void>;
    nextPage(): void;
    previousPage(): void;
    /**
     * @param page The **1-based** page number
     */
    goToPage(page: number): void;
    private setPageNumberInUrl;
    deleteDoorkey(doorkey: Doorkey): void;
}
