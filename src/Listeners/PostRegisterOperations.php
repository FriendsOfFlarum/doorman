<?php

/*
 * This file is part of fof/doorman.
 *
 * Copyright (c) Reflar.
 * Copyright (c) FriendsOfFlarum.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

namespace FoF\Doorman\Listeners;

use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\Event\GroupsChanged;
use Flarum\User\Event\Registered;
use FoF\Doorman\Doorkey;
use Illuminate\Contracts\Events\Dispatcher;

class PostRegisterOperations
{
    /**
     * @var SettingsRepositoryInterface
     */
    protected $settings;

    /**
     * @var Dispatcher
     */
    protected $events;

    public function __construct(SettingsRepositoryInterface $settings, Dispatcher $events)
    {
        $this->settings = $settings;
        $this->events = $events;
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
            $oldGroups = $user->groups()->get()->all();

            $user->groups()->attach($doorkey->group_id);

            $this->events->dispatch(
                new GroupsChanged($user, $oldGroups)
            );
        }

        $doorkey->increment('uses');

        $user->save();
    }
}
