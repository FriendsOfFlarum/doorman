# Doorman by FriendsOfFlarum

[![GitLab license](https://img.shields.io/badge/license-MIT-blue.svg)](https://github.com/FriendsOfFlarum/doorman/blob/master/LICENSE.md) [![Latest Stable Version](https://img.shields.io/packagist/v/fof/doorman.svg)](https://github.com/FriendsOfFlarum/doorman) [![OpenCollective](https://img.shields.io/badge/opencollective-fof-blue.svg)](https://opencollective.com/fof/donate)

A [Flarum](http://flarum.org) extension that restricts sign-ups to user's who have a code created in the admin panel.

Each code can be set to have a maximum number of uses, what group the user should be automatically added to on sign up, and whether or not the user should be automatically activated.

### Usage

- Setup sign-up codes on the admin panel
- Includes optional support for [Direct Links](https://github.com/FriendsOfFlarum/direct-links). When this extension is also enabled, email invites will include a link which will take the uew user directly to the signup modal, rather than the forum home page.

### Installation

Install with composer:

```bash
composer require fof/doorman:"*"
```

Then login and enable the extension.

### To Do

- Allow already signed up users to create codes for others to use (referrals)

### Issues

- [Open an issue on Github](https://github.com/FriendsOfFlarum/doorman/issues)

### Links

- [On Github](https://github.com/FriendsOfFlarum/doorman)
- [On Packagist](https://packagist.org/packages/fof/doorman)
