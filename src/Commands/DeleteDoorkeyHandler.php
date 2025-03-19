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

namespace FoF\Doorman\Commands;

use FoF\Doorman\Doorkey;
use FoF\Doorman\Events\DoorkeyDeleting;
use Illuminate\Contracts\Events\Dispatcher;

class DeleteDoorkeyHandler
{
    /**
     * @var Dispatcher
     */
    protected $events;

    public function __construct(Dispatcher $events)
    {
        $this->events = $events;
    }

    /**
     * @param DeleteDoorkey $command
     *
     * @return mixed
     */
    public function handle(DeleteDoorkey $command)
    {
        $doorkey = Doorkey::where('id', $command->doorkeyId)->firstOrFail();

        $actor = $command->actor;

        $this->events->dispatch(
            new DoorkeyDeleting($doorkey, $actor, [])
        );

        $doorkey->delete();

        return $doorkey;
    }
}
