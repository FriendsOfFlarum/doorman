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

use Flarum\User\User;

class DeleteDoorkey
{
    /**
     * DeleteDoorkey constructor.
     *
     */
    public function __construct(public $doorkeyId, public User $actor)
    {
    }
}
