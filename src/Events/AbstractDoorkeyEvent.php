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

namespace FoF\Doorman\Events;

use Flarum\User\User;
use FoF\Doorman\Doorkey;

abstract class AbstractDoorkeyEvent
{
    public function __construct(public Doorkey $doorkey, public User $actor, public array $data)
    {
    }
}
