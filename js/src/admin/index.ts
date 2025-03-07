import app from 'flarum/admin/app';
import SettingsPage from './components/SettingsPage';
import DoorkeyListPage from './components/DoorkeyListPage';

export { default as extend } from './extend';

app.initializers.add('fof-doorman', () => {
  app.extensionData.for('fof-doorman').registerPage(SettingsPage);
  //app.extensionData.for('fof-doorman').registerPage(DoorkeyListPage);
});
