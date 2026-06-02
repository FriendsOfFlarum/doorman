import app from 'flarum/forum/app';
import extendSignUpModal from './extenders/extendSignUpModal';

app.initializers.add('fof-doorman', () => {
  extendSignUpModal();
});
