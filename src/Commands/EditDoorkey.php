<?php
/**
 *  This file is part of reflar/doorman.
 *
 *  Copyright (c) 2018 ReFlar.
 *
 *  https://reflar.redevs.org
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Reflar\Doorman\Commands;

use Flarum\User\User;

class EditDoorkey
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
     * @var array
     */
    public $data;

    /**
     * @param int   $doorkeyId
     * @param User  $actor
     * @param array $data
     */
    public function __construct($doorkeyId, User $actor, array $data)
    {
        $this->doorkeyId = $doorkeyId;
        $this->actor = $actor;
        $this->data = $data;
    }
}
