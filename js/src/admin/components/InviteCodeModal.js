import Alert from 'flarum/components/Alert';
import Modal from 'flarum/components/Modal';
import Button from 'flarum/components/Button';

export default class InviteCodeModal extends Modal {
  init() {
    super.init();

    this.emails = [];

    this.doorkey = this.props.doorkey;

    this.success = false;
  }

  className() {
    return 'InviteCodeModal Modal--small';
  }

  title() {
    return app.translator.trans('reflar-doorman.admin.modal.title');
  }

  config() {
    $('#EmailInput').off().on('keydown', (e) => {
      if (e.keyCode === 13 || e.keyCode === 188 || e.keyCode === 32) {
        e.preventDefault();
        this.addEmails()
      }
    });
  }

  content() {
    return (
      <div className="Modal-body">
        <h3>{app.translator.trans('reflar-doorman.admin.modal.group', {group: app.store.getById('groups', this.doorkey.groupId()).nameSingular()})}</h3>
        <div className="helpText">
          {app.translator.trans('reflar-doorman.admin.modal.help')}
        </div>
        <div className="Form Form--centered">
          <div className="Form-group">
            <input
              type="text"
              name="text"
              id="EmailInput"
              className="FormControl"
              placeholder={app.translator.trans('reflar-doorman.admin.modal.placeholder')}
              disabled={this.loading}
            />
          </div>
          <div className="Form-group">
            <ul>
              {this.emails.map((email, i) => {
                return (
                  <li className="emailListItem">
                    <p>{email}</p>
                    {Button.component({
                      className: 'Button',
                      loading: this.loading,
                      icon: 'fas fa-times',
                      onclick: this.removeEmail.bind(this, i)
                    })}
                  </li>
                )
              })}
            </ul>
          </div>
          <div className="Form-group">
            {Button.component({
              className: 'Button Button--primary Button--block',
              loading: this.loading,
              onclick: this.send.bind(this),
              disabled: this.emails.length === 0,
              children: app.translator.trans('reflar-doorman.admin.modal.send')
            })}
          </div>
        </div>
      </div>
    );
  }

  addEmails() {
    this.alert = null;
    m.redraw();
    this.badEmails = [];

    const value = $('#EmailInput').val();

    value.split(/[ ,]+/).map(email => {
      if (!this.emails.includes(email)) {
        if (this.emails.length + 1 > this.doorkey.data.attributes.maxUses) {
          this.alert = new Alert({
            type: 'error',
            children: app.translator.trans('reflar-doorman.admin.modal.max_use_conflict')
          });
          m.redraw();
        } else {
          if (this.validateEmail(email)) {
            this.emails.push(email);
            $('#EmailInput').val('');
            m.redraw();
          } else {
            this.badEmails.push(email);
            this.alert = new Alert({
              type: 'error',
              children: app.translator.trans('reflar-doorman.admin.modal.invalid_emails', {emails: this.badEmails.join(', ')})
            });
            m.redraw();
          }
        }
      }
    })
  }

  validateEmail(email) {
    const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(String(email).toLowerCase());
  }

  removeEmail(i) {
    this.emails.splice(i, 1);
  }

  send(e) {
    e.preventDefault();

    this.alert = null;

    this.loading = true;

    app.request({
      method: 'POST',
      url: app.forum.attribute('apiUrl') + '/reflar/doorkeys/invites',
      data: {
        emails: this.emails,
        doorkeyId: this.doorkey.data.id
      }
    }).then(() => {
      app.modal.close();
      app.alerts.show(
        new Alert({
          type: 'success',
          children: app.translator.trans('reflar-doorman.admin.modal.success')
        })
      )
    })
  }
}
