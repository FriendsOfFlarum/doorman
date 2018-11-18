import app from 'flarum/app';
import { extend } from 'flarum/extend';
import SignUpModal from 'flarum/components/SignUpModal';

app.initializers.add('reflar/doorman', () => {
    extend(SignUpModal.prototype, 'fields', function(fields) {
        fields.add(
            'reflar-doorman',
            <div className="Form-group">
                <input
                    className="FormControl"
                    name="reflar-doorman"
                    type="text"
                    placeholder={app.translator.trans('reflar-doorman.forum.sign_up.doorman_placeholder')}
                    bidi={this['reflar-doorman']}
                    disabled={this.loading}
                />
            </div>
        );
    });
});
