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

use Flarum\User\Event\Saving;

class ClearBypass
{
    public function handle(Saving $event)
    {
        if ($event->user->fofDoorkeyBypass) {
            unset($event->user->fofDoorkeyBypass);
        }
    }
}
