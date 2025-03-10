import app from 'flarum/admin/app';
import ExtensionPage from 'flarum/admin/components/ExtensionPage';
import { debounce } from 'flarum/common/utils/throttleDebounce';
import LoadingIndicator from 'flarum/common/components/LoadingIndicator';
import Button from 'flarum/common/components/Button';
import ItemList from 'flarum/common/utils/ItemList';
import classList from 'flarum/common/utils/classList';
import extractText from 'flarum/common/utils/extractText';
import GroupBadge from 'flarum/common/components/GroupBadge';
import Group from 'flarum/common/models/Group';

import CreateDoorkeyModal from './CreateDoorkeyModal';
import InviteCodeModal from './InviteCodeModal';

import type { ExtensionPageAttrs } from 'flarum/admin/components/ExtensionPage';
import type Doorkey from 'src/common/models/Doorkey';
import type Mithril from 'mithril';
import EditDoorkeyModal from './EditDoorkeyModal';

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
  private query: string = '';
  private throttledSearch = debounce(250, () => this.loadPage(0));

  /**
   * Number of doorkeys to load per page.
   */
  private numPerPage: number = 5;

  /**
   * Current page number. Zero-indexed.
   */
  private pageNumber: number = 0;

  /**
   * Page number being loaded. Zero-indexed.
   */
  private loadingPageNumber: number = 0;

  /**
   * Total number of doorkeys.
   *
   * Fetched from the active `AdminApplication` (`app`), with
   * data provided by `AdminPayload.php`.
   */
  readonly doorkeyCount: number = app.data.modelStatistics.doorkeys.total;

  loadingDelete: { [key: string]: boolean } = {};

  /**
   * Get total number of doorkey pages.
   */
  private getTotalPageCount(): number {
    if (this.doorkeyCount === -1) return 0;

    return Math.ceil(this.doorkeyCount / this.numPerPage);
  }

  /**
   * This page's array of doorkeys.
   *
   * `undefined` when page loads as no data has been fetched.
   */
  private pageData: Doorkey[] | undefined = undefined;

  /**
   * Are there more doorkeys available?
   */
  private moreData: boolean = false;

  private isLoadingPage: boolean = false;

  oninit(vnode: Mithril.Vnode<ExtensionPageAttrs, this>) {
    super.oninit(vnode);

    // Get page query value from URL
    const page = parseInt(m.route.param('page'));

    if (isNaN(page) || page < 1) {
      this.setPageNumberInUrl(1);
      this.pageNumber = 0;
    } else {
      this.pageNumber = page - 1;
    }

    this.loadingPageNumber = this.pageNumber;
  }

  /**
   * Component to render.
   */
  content(): JSX.Element {
    if (typeof this.pageData === 'undefined') {
      this.loadPage(this.pageNumber);

      return (
        <section className="DoorkeyListPage-grid DoorkeyListPage-grid--loading">
          <LoadingIndicator containerClassName="LoadingIndicator--block" size="large" />
        </section>
      );
    }

    const columns = this.columns().toArray();

    return (
      <div className="container">
        <div className="DoorkeyListPage-header">{this.headerItems().toArray()}</div>

        <div className="Doorkey-allowPublic">
          {this.buildSettingComponent({
            type: 'boolean',
            setting: 'fof-doorman.allowPublic',
            label: app.translator.trans('fof-doorman.admin.page.doorkey.allow-public.switch-label'),
          })}

          {this.submitButton()}
        </div>

        <section
          className={classList(['DoorkeyListPage-grid', this.isLoadingPage ? 'DoorkeyListPage-grid--loadingPage' : 'DoorkeyListPage-grid--loaded'])}
          style={{ '--columns': columns.length }}
          role="table"
          // +1 to account for header
          aria-rowcount={this.pageData.length + 1}
          aria-colcount={columns.length}
          aria-live="polite"
          aria-busy={this.isLoadingPage ? 'true' : 'false'}
        >
          {/* Render columns */}
          {columns.map((column, colIndex) => (
            <div className="DoorkeyListPage-grid-header" role="columnheader" aria-colindex={colIndex + 1} aria-rowindex={1}>
              {column.name}
            </div>
          ))}

          {/* Render doorkey data */}
          {this.pageData.map((doorkey, rowIndex) =>
            columns.map((col, colIndex) => {
              const columnContent = col.content && col.content(doorkey);

              return (
                <div
                  className={classList(['DoorkeyListPage-grid-rowItem', rowIndex % 2 > 0 && 'DoorkeyListPage-grid-rowItem--shaded'])}
                  data-doorkey-id={doorkey.id()}
                  data-column-name={col.itemName}
                  aria-colindex={colIndex + 1}
                  // +2 to account for 0-based index, and for the header row
                  aria-rowindex={rowIndex + 2}
                  role="cell"
                >
                  {columnContent || app.translator.trans('fof-doorman.admin.page.doorkey.heading.invalid_column_content')}
                </div>
              );
            })
          )}

          {/* Loading spinner that shows when a new page is being loaded */}
          {this.isLoadingPage && <LoadingIndicator size="large" />}
        </section>

        <nav className="DoorkeyListPage-gridPagination">
          <Button
            disabled={this.pageNumber === 0}
            title={app.translator.trans('fof-doorman.admin.page.doorkey.pagination.first_page_button')}
            onclick={this.goToPage.bind(this, 1)}
            icon="fas fa-step-backward"
            className="Button Button--icon DoorkeyListPage-firstPageBtn"
          />
          <Button
            disabled={this.pageNumber === 0}
            title={app.translator.trans('fof-doorman.admin.page.doorkey.pagination.back_button')}
            onclick={this.previousPage.bind(this)}
            icon="fas fa-chevron-left"
            className="Button Button--icon DoorkeyListPage-backBtn"
          />
          <span className="DoorkeyListPage-pageNumber">
            {app.translator.trans('fof-doorman.admin.page.doorkey.pagination.page_counter', {
              current: (
                <input
                  type="text"
                  inputmode="numeric"
                  pattern="[0-9]*"
                  value={this.loadingPageNumber + 1}
                  aria-label={extractText(app.translator.trans('fof-doorman.admin.page.doorkey.pagination.go_to_page_textbox_a11y_label'))}
                  autocomplete="off"
                  className="FormControl DoorkeyListPage-pageNumberInput"
                  onchange={(e: InputEvent) => {
                    const target = e.target as HTMLInputElement;
                    let pageNumber = parseInt(target.value);

                    if (isNaN(pageNumber)) {
                      // Invalid value, reset to current page
                      target.value = (this.pageNumber + 1).toString();
                      return;
                    }

                    if (pageNumber < 1) {
                      // Lower constraint
                      pageNumber = 1;
                    } else if (pageNumber > this.getTotalPageCount()) {
                      // Upper constraint
                      pageNumber = this.getTotalPageCount();
                    }

                    target.value = pageNumber.toString();

                    this.goToPage(pageNumber);
                  }}
                />
              ),
              currentNum: this.pageNumber + 1,
              total: this.getTotalPageCount(),
            })}
          </span>
          <Button
            disabled={!this.moreData}
            title={app.translator.trans('fof-doorman.admin.page.doorkey.pagination.next_button')}
            onclick={this.nextPage.bind(this)}
            icon="fas fa-chevron-right"
            className="Button Button--icon DoorkeyListPage-nextBtn"
          />
          <Button
            disabled={!this.moreData}
            title={app.translator.trans('fof-doorman.admin.page.doorkey.pagination.last_page_button')}
            onclick={this.goToPage.bind(this, this.getTotalPageCount())}
            icon="fas fa-step-forward"
            className="Button Button--icon DoorkeyListPage-lastPageBtn"
          />
        </nav>
      </div>
    );
  }

  headerItems(): ItemList<Mithril.Children> {
    const items = new ItemList<Mithril.Children>();

    items.add(
      'search',
      <div className="Search-input">
        <input
          className="FormControl SearchBar"
          type="search"
          placeholder={app.translator.trans('fof-doorman.admin.page.search')}
          oninput={(e: InputEvent) => {
            this.isLoadingPage = true;
            this.query = (e?.target as HTMLInputElement)?.value;
            this.throttledSearch();
          }}
        />
      </div>,
      100
    );

    items.add(
      'totalDoorkeys',
      <p class="DoorkeyListPage-totalDoorkeys">{app.translator.trans('fof-doorman.admin.page.total_doorkeys', { count: this.doorkeyCount })}</p>,
      90
    );

    items.add('actions', <div className="DoorkeyListPage-actions">{this.actionItems().toArray()}</div>, 80);

    return items;
  }

  actionItems(): ItemList<Mithril.Children> {
    const items = new ItemList<Mithril.Children>();

    items.add(
      'createUser',
      <Button className="Button DoorkeyListPage-createDoorkeyBtn" icon="fas fa-door-open" onclick={() => app.modal.show(CreateDoorkeyModal)}>
        {app.translator.trans('fof-doorman.admin.create_doorkey_button')}
      </Button>,
      100
    );

    return items;
  }

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
  columns(): ItemList<ColumnData> {
    const columns = new ItemList<ColumnData>();

    columns.add(
      'id',
      {
        name: app.translator.trans('fof-doorman.admin.page.doorkey.heading.id'),
        content: (doorkey: Doorkey) => doorkey.id(),
      },
      100
    );

    columns.add(
      'key',
      {
        name: app.translator.trans('fof-doorman.admin.page.doorkey.heading.key'),
        content: (doorkey: Doorkey) => doorkey.key() ?? null,
      },
      90
    );

    columns.add(
      'group',
      {
        name: app.translator.trans('fof-doorman.admin.page.doorkey.heading.group'),
        content: (doorkey: Doorkey) => {
          const group = doorkey.group();
          if (group && group.id() === Group.MEMBER_ID) return app.translator.trans('fof-doorman.admin.page.doorkey.content.no_group');

          return <GroupBadge group={doorkey.group()} />;
        },
      },
      80
    );

    columns.add(
      'maxUses',
      {
        name: app.translator.trans('fof-doorman.admin.page.doorkey.heading.max_uses'),
        content: (doorkey: Doorkey) => doorkey.maxUses() ?? null,
      },
      70
    );

    columns.add(
      'activates',
      {
        name: app.translator.trans('fof-doorman.admin.page.doorkey.heading.activates'),
        content: (doorkey: Doorkey) => doorkey.activates() ?? null,
      },
      60
    );

    columns.add(
      'manage',
      {
        name: null,
        content: (doorkey: Doorkey) => (
          <>
            <Button
              aria-label={app.translator.trans('fof-doorman.admin.page.doorkey.heading.notify')}
              className="Button Button--icon Doorkey-button"
              icon="fa fa-envelope fa-fw"
              onclick={() => app.modal.show(InviteCodeModal, { doorkey: doorkey })}
            />
            <Button
              aria-label={app.translator.trans('fof-doorman.admin.page.doorkey.heading.edit')}
              className="Button Button--icon Doorkey-button"
              icon="fas fa-pencil-alt"
              onclick={() => app.modal.show(EditDoorkeyModal, { doorkey })}
            />
            <Button
              aria-label={app.translator.trans('fof-doorman.admin.page.doorkey.heading.delete')}
              className="Button Button--danger Button--icon"
              icon={`fas ${this.loadingDelete[doorkey.id() || ''] ? 'fa-circle-notch fa-spin' : 'fa-times'} fa-fw`}
              onclick={() => this.deleteDoorkey(doorkey)}
            />
          </>
        ),
      },
      50
    );

    return columns;
  }

  /**
   * Asynchronously fetch the next set of doorkeys to be rendered.
   *
   * Returns an array of doorkeys, plus the raw API payload.
   *
   * Uses the `this.numPerPage` as the response limit, and automatically calculates the offset required from `pageNumber`.
   *
   * @param pageNumber The **zero-based** page number to load and display
   */
  async loadPage(pageNumber: number) {
    if (pageNumber < 0) pageNumber = 0;

    this.loadingPageNumber = pageNumber;
    this.setPageNumberInUrl(pageNumber + 1);

    app.store
      .find<Doorkey[]>('fof/doorkeys', {
        filter: { q: this.query },
        page: {
          limit: this.numPerPage,
          offset: pageNumber * this.numPerPage,
        },
      })
      .then((apiData) => {
        // Next link won't be present if there's no more data
        this.moreData = !!apiData.payload?.links?.next;

        let data = apiData;

        // @ts-ignore
        delete data.payload;

        const lastPage = this.getTotalPageCount();

        if (pageNumber > lastPage) {
          this.loadPage(lastPage - 1);
        } else {
          this.pageData = data;
          this.pageNumber = pageNumber;
          this.loadingPageNumber = pageNumber;
          this.isLoadingPage = false;
        }

        m.redraw();
      })
      .catch((err: Error) => {
        console.error(err);
        this.pageData = [];
      });
  }

  nextPage() {
    this.isLoadingPage = true;
    this.loadPage(this.pageNumber + 1);
  }

  previousPage() {
    this.isLoadingPage = true;
    this.loadPage(this.pageNumber - 1);
  }

  /**
   * @param page The **1-based** page number
   */
  goToPage(page: number) {
    this.isLoadingPage = true;
    this.loadPage(page - 1);
  }

  private setPageNumberInUrl(pageNumber: number) {
    const search = window.location.hash.split('?', 2);
    const params = new URLSearchParams(search?.[1] ?? '');

    params.set('page', `${pageNumber}`);
    window.location.hash = search?.[0] + '?' + params.toString();
  }

  deleteDoorkey(doorkey: Doorkey) {
    const doorkeyId = doorkey.id();
    if (doorkeyId) {
      this.loadingDelete[doorkeyId] = true;
      m.redraw();

      doorkey.delete().finally(() => {
        this.loadingDelete[doorkeyId] = false;
        m.redraw();
      });
    }
  }
}
