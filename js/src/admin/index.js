import app from 'flarum/app';

app.initializers.add('reflar/doorman', () => {
  console.log('Hello, admin!');
});
