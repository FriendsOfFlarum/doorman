<?php

/**
 *  This file is part of reflar/doorman.
 *
 *  Copyright (c) 2018 ReFlar.
 *
 *  https://reflar.redevs.org
 *
 *  For the full copyright and license information, please view the LICENSE.md
 *  file that was distributed with this source code.
 */

namespace Reflar\Doorman\Listeners;

use Flarum\User\Event\Registered;
use Illuminate\Contracts\Events\Dispatcher;
use Reflar\Doorman\Doorkey;

class PostRegisterOperations
{
    /**
     * @param Dispatcher $events
     *
     * @return void
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Registered::class, [$this, 'useDoorkey']);
    }

    public function useDoorkey(Registered $event)
    {
        $user = $event->user;
        $doorkey = Doorkey::where('key', $user->invite_code)->first();

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
