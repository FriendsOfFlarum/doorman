<?php

/*
 * This file is part of fof/doorman.
 *
 * Copyright (c) 2018-2020 Reflar.
 * Copyright (c) 2020 FriendsOfFlarum
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 *
 */

namespace FoF\Doorman\Commands;

use Flarum\User\User;

class DeleteDoorkey
{
    /**
     * @var int
     */
    public $doorkeyId;

    /**
     * @var User
     */
    public $actor;

    /**
     * DeleteDoorkey constructor.
     *
     * @param $doorkeyId
     * @param User $actor
     */
    public function __construct($doorkeyId, User $actor)
    {
        $this->doorkeyId = $doorkeyId;
        $this->actor = $actor;
    }
}
