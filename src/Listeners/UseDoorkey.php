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

use Illuminate\Contracts\Events\Dispatcher;
use Flarum\User\Event\Saving;
use Reflar\Doorman\Doorkey;
use Reflar\Doorman\Validators\DoorkeyLoginValidator;

class UseDoorkey
{

    /**
     * @param Dispatcher $events
     * @return void
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Saving::class, [$this, 'useDoorkey']);
    }

    public function useDoorkey(Saving $event)
    {
        die(var_dump($event->data));
    }
}
