import DoorkeyListPage from './DoorkeyListPage';

// Only the list page is part of the main admin bundle. The Create/Edit/Invite
// modals are loaded on demand via dynamic `import()` (see DoorkeyListPage), so
// they are split into separate chunks and intentionally kept out of this barrel.
export const components = {
  DoorkeyListPage,
};
