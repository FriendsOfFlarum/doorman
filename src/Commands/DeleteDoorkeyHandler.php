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

use Flarum\User\Exception\PermissionDeniedException;
use FoF\Doorman\Doorkey;
use FoF\Doorman\Events\DoorkeyDeleted;
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
     * @throws PermissionDeniedException
     *
     * @return mixed
     */
    public function handle(DeleteDoorkey $command)
    {
        $actor = $command->actor;

        $actor->assertAdmin();

        $doorkey = Doorkey::where('id', $command->doorkeyId)->firstOrFail();

        $doorkey->delete();

        $this->events->dispatch(
            new DoorkeyDeleted($doorkey, $actor, [])
        );

        return $doorkey;
    }
}
