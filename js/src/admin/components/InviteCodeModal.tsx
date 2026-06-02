import Form from 'flarum/common/components/Form';
import app from 'flarum/admin/app';
import { IFormModalAttrs } from 'flarum/common/components/FormModal';
import FormModal from 'flarum/common/components/FormModal';
import Button from 'flarum/common/components/Button';
import Alert from 'flarum/common/components/Alert';
import Stream from 'flarum/common/utils/Stream';
import Group from 'flarum/common/models/Group';

import type Doorkey from '../../common/models/Doorkey';
import type Mithril from 'mithril';

export interface IInviteCodeModalAttrs extends IFormModalAttrs {
  doorkey: Doorkey;
}

// https://stackoverflow.com/a/46181/11091039
const EMAIL_REGEX =
  /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

export default class InviteCodeModal<CustomAttrs extends IInviteCodeModalAttrs = IInviteCodeModalAttrs> extends FormModal<CustomAttrs> {
  protected doorkey!: Doorkey;

  /**
   * Addresses queued to receive an invite.
   */
  protected emails!: string[];

  /**
   * The current value of the email input (not yet committed to {@link emails}).
   */
  protected input!: Stream<string>;

  protected badEmails: string[] = [];
  protected alert: number | undefined;

  oninit(vnode: Mithril.Vnode<CustomAttrs, this>) {
    super.oninit(vnode);

    this.doorkey = this.attrs.doorkey;
    this.emails = [];
    this.input = Stream('');
  }

  className() {
    return 'InviteCodeModal Modal--small';
  }

  title() {
    return app.translator.trans('fof-doorman.admin.modals.send_invites.title');
  }

  onremove(vnode: Mithril.VnodeDOM<CustomAttrs, this>) {
    super.onremove(vnode);

    if (this.alert) app.alerts.dismiss(this.alert);
  }

  content() {
    const group = app.store.getById<Group>('groups', String(this.doorkey.groupId()));

    return (
      <div className="Modal-body">
        <h3>
          {app.translator.trans('fof-doorman.admin.modals.send_invites.group', {
            group: group ? group.nameSingular() : this.doorkey.groupId(),
          })}
        </h3>
        <div className="helpText">{app.translator.trans('fof-doorman.admin.modals.send_invites.help')}</div>
        <Form className="Form--centered">
          <div className="Form-group">
            <input
              type="text"
              name="email"
              className="FormControl"
              placeholder={app.translator.trans('fof-doorman.admin.modals.send_invites.placeholder')}
              bidi={this.input}
              disabled={this.loading}
              onkeydown={(e: KeyboardEvent) => {
                // Enter, comma or space commits the current address as a chip
                // rather than submitting the whole form.
                if (e.key === 'Enter' || e.key === ',' || e.key === ' ') {
                  e.preventDefault();
                  this.addEmails();
                }
              }}
            />
          </div>

          {this.emails.length > 0 && (
            <div className="Form-group">
              <ul>
                {this.emails.map((email, i) => (
                  <li className="emailListItem">
                    <p>{email}</p>
                    {Button.component({
                      className: 'Button',
                      loading: this.loading,
                      icon: 'fas fa-times',
                      onclick: () => this.removeEmail(i),
                    })}
                  </li>
                ))}
              </ul>
            </div>
          )}

          <div className="Form-group">
            {Button.component(
              {
                type: 'submit',
                className: 'Button Button--primary Button--block',
                loading: this.loading,
                disabled: !this.hasSendableEmails(),
              },
              app.translator.trans('fof-doorman.admin.modals.send_invites.send')
            )}
          </div>
        </Form>
      </div>
    );
  }

  /**
   * The send button is enabled when at least one address is queued, or the
   * input currently holds a valid (not-yet-committed) address.
   */
  hasSendableEmails(): boolean {
    return this.emails.length > 0 || this.validateEmail(this.input().trim());
  }

  /**
   * Move valid addresses from the input into the queued {@link emails} list.
   */
  addEmails(): void {
    if (this.alert) app.alerts.dismiss(this.alert);
    this.badEmails = [];

    const value = this.input().trim();
    if (value === '') return;

    value.split(/[\s,]+/).forEach((raw: string) => {
      const email = raw.trim();

      if (email === '' || this.emails.includes(email)) return;

      const maxUses = this.doorkey.maxUses();
      const uses = this.doorkey.uses();

      if (maxUses > 0 && uses + this.emails.length + 1 > maxUses) {
        this.alert = app.alerts.show(Alert, { type: 'error' }, app.translator.trans('fof-doorman.admin.modals.send_invites.max_use_conflict'));
        return;
      }

      if (this.validateEmail(email)) {
        this.emails.push(email);
      } else {
        this.badEmails.push(email);
      }
    });

    if (this.badEmails.length > 0) {
      this.alert = app.alerts.show(
        Alert,
        { type: 'error' },
        app.translator.trans('fof-doorman.admin.modals.send_invites.invalid_emails', { emails: this.badEmails.join(', ') })
      );
    }

    this.input('');
  }

  validateEmail(email: string): boolean {
    return EMAIL_REGEX.test(String(email).toLowerCase());
  }

  removeEmail(index: number): void {
    this.emails.splice(index, 1);
  }

  onsubmit(e: SubmitEvent) {
    e.preventDefault();

    // Commit any address still sitting in the input before sending.
    if (this.input().trim() !== '') {
      this.addEmails();
    }

    if (this.emails.length === 0) return;

    if (this.alert) app.alerts.dismiss(this.alert);
    this.loading = true;

    app
      .request({
        method: 'POST',
        url: app.forum.attribute('apiUrl') + '/doorkeys/invites',
        body: {
          emails: this.emails,
          doorkeyId: this.doorkey.id(),
        },
        errorHandler: this.onerror.bind(this),
      })
      .then(() => {
        app.modal.close();
        app.alerts.show(Alert, { type: 'success' }, app.translator.trans('fof-doorman.admin.modals.send_invites.success'));
      })
      .finally(() => this.loaded());
  }
}
