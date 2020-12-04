import app from 'flarum/app';
import addSettingsPage from './addSettingsPage';
import Doorkey from './models/Doorkey';

app.initializers.add('fof-doorman', () => {
    app.store.models.doorkeys = Doorkey;

    addSettingsPage();
});
