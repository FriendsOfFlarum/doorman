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

class DeleteDoorkeyHandler
{
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

        return $doorkey;
    }
}
