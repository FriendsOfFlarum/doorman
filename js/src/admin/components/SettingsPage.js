import Page from 'flarum/components/Page';
import LoadingIndicator from 'flarum/components/LoadingIndicator';

export default class DoormanSettingsPage extends Page {
    init() {
        super.init();

        this.loading = false;
        this.doorkeys = null;
    }

    view() {
        const title = app.translator.trans('reflar-doorman.admin.page.title');

        if (!this.doorkeys) {
            if (!this.loading) {
                app.store.find('reflar/doorkeys').then(res => {
                    this.doorkeys = res.payload.data;
                    this.loading = false;
                    m.lazyRedraw();
                });

                this.loading = true;
            }

            return (
                <div className="container">
                    <h2>{title}</h2>
                    <LoadingIndicator />
                </div>
            );
        }

        return (
            <div className="SettingsPage--Doorman">
                <div className="container">
                    <h2>{title}</h2>

                    <div className="Doorkeys--Container">{this.doorkeys}</div>
                </div>
            </div>
        );
    }
}
