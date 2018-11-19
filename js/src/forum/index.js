import app from 'flarum/app';
import { extend } from 'flarum/extend';
import SignUpModal from 'flarum/components/SignUpModal';

app.initializers.add('reflar-doorman', () => {
    extend(SignUpModal.prototype, 'init', function() {
        this.doorkey = m.prop('');
    });
    extend(SignUpModal.prototype, 'fields', function(fields) {
        fields.add(
            'doorkey',
            <div className="Form-group">
                <input
                    className="FormControl"
                    name="reflar-doorkey"
                    type="text"
                    placeholder={app.translator.trans('reflar-doorman.forum.sign_up.doorman_placeholder')}
                    bidi={this.doorkey}
                    disabled={this.loading}
                />
            </div>
        );
    });

    extend(SignUpModal.prototype, 'submitData', function (data) {
        const newData = data;
        newData['reflar-doorkey'] = this.doorkey;
        return newData;
    });
});
