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

namespace FoF\Doorman\Listeners;

use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\Event\Registered;
use FoF\Doorman\Doorkey;

class PostRegisterOperations
{
    protected $settings;

    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    public function handle(Registered $event)
    {
        $user = $event->user;
        $doorkey = Doorkey::where('key', $user->invite_code)->first();

        // Allows the invitation key to be optional if the setting was enabled
        $allow = json_decode($this->settings->get('fof-doorman.allowPublic'));
        if ($allow && !$doorkey) {
            return;
        }

        if ($doorkey->activates) {
            $user->activate();
        }

        if ($doorkey->group_id !== 3) {
            $user->groups()->attach($doorkey->group_id);
        }

        $doorkey->increment('uses');

        $user->save();
    }
}
