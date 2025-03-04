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
    /**
     * @var Doorkey
     */
    public $doorkey;

    /**
     * @var User
     */
    public $actor;

    /**
     * @var array
     */
    public array $data;

    public function __construct(Doorkey $doorkey, User $actor, array $data)
    {
        $this->doorkey = $doorkey;
        $this->actor = $actor;
        $this->data = $data;
    }
}
