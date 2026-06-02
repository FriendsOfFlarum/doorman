import app from 'flarum/forum/app';
import { extend } from 'flarum/common/extend';
import Stream from 'flarum/common/utils/Stream';

export default function extendSignUpModal() {
  extend('flarum/forum/components/SignUpModal', 'oninit', function () {
    this.doorkey = Stream('');
  });
  extend('flarum/forum/components/SignUpModal', 'fields', function (fields) {
    if (this.attrs.provided && this.attrs.provided.includes('fofDoorkeyBypass')) {
      // unset `fof-doorkey.bypass` if it is set
      this.attrs.provided = this.attrs.provided.filter((item: string) => item !== 'fofDoorkeyBypass');
      return;
    }

    const isOptional = app.forum.data?.attributes?.['fof-doorman.allowPublic'];
    const placeholder = isOptional
      ? app.translator.trans('fof-doorman.forum.sign_up.doorman_placeholder_optional')
      : app.translator.trans('fof-doorman.forum.sign_up.doorman_placeholder');

    fields.add(
      'doorkey',
      <div className="Form-group">
        <input className="FormControl" name="fof-doorkey" type="text" placeholder={placeholder} bidi={this.doorkey} disabled={this.loading} />
      </div>
    );
  });

  extend('flarum/forum/components/SignUpModal', 'submitData', function (data) {
    const newData = data;
    newData['fof-doorkey'] = this.doorkey().trim();
    return newData;
  });
}
