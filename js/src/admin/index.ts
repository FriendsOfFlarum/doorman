import app from 'flarum/admin/app';
import DoorkeyListPage from './components/DoorkeyListPage';

export { default as extend } from './extend';

export * from './components';

app.initializers.add('fof-doorman', () => {
  app.extensionData.for('fof-doorman').registerPage(DoorkeyListPage);
});
