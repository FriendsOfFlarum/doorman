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
use FoF\Doorman\Events\DoorkeyUsed;
use FoF\Doorman\Repository\DoorkeyRepository;
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

    /**
     * @var DoorkeyRepository
     */
    protected $doorkeys;

    public function __construct(SettingsRepositoryInterface $settings, Dispatcher $events, DoorkeyRepository $doorkeys)
    {
        $this->settings = $settings;
        $this->events = $events;
        $this->doorkeys = $doorkeys;
    }

    public function handle(Registered $event)
    {
        $user = $event->user;

        $doorkey = $this->doorkeys->getByKey($user->invite_code);

        // Allows the invitation key to be optional if the setting was enabled
        $allow = json_decode($this->settings->get('fof-doorman.allowPublic'));
        if ($allow && !$doorkey) {
            return;
        }

        if (empty($doorkey)) {
            return;
        }

        if ($doorkey->group_id !== 3) {
            $oldGroups = $user->groups()->get()->all();

            $user->groups()->attach($doorkey->group_id);

            $this->events->dispatch(
                new GroupsChanged($user, $oldGroups)
            );
        }

        $user->save();

        if ($doorkey) {
            $doorkey->increment('uses');

            $this->events->dispatch(
                new DoorkeyUsed($doorkey, $user, [])
            );
        }
    }
}
