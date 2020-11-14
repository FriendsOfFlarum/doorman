<?php

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