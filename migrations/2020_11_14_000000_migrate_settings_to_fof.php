<?php

/*
 * This file is part of fof/doorman.
 *
 * Copyright (c) 2018-2020 Reflar.
 * Copyright (c) 2020 FriendsOfFlarum
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 *
 */

use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        /**
         * @var \Flarum\Settings\SettingsRepositoryInterface
         */
        $settings = app('flarum.settings');

        foreach (['allowPublic'] as $setting) {
            if ($value = $settings->get($key = "reflar.doorman.$setting")) {
                $settings->set("fof-doorman.$setting", $value);
                $settings->delete($key);
            }
        }
    },
    'down' => function (Builder $schema) {
        /**
         * @var \Flarum\Settings\SettingsRepositoryInterface
         */
        $settings = app('flarum.settings');

        foreach (['allowPublic'] as $setting) {
            if ($value = $settings->get($key = "fof-doorman.$setting")) {
                $settings->set("reflar.doorman.$setting", $value);
                $settings->delete($key);
            }
        }
    },
];
