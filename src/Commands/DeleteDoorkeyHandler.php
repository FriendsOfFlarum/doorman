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

class DeleteDoorkeyHandler
{
    /**
     * @param DeleteDoorkey $command
     *
     * @return mixed
     */
    public function handle(DeleteDoorkey $command)
    {
        $doorkey = Doorkey::where('id', $command->doorkeyId)->firstOrFail();

        $doorkey->delete();

        return $doorkey;
    }
}
