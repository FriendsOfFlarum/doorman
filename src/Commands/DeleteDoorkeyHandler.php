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

use Flarum\User\AssertPermissionTrait;
use Flarum\User\Exception\PermissionDeniedException;
use Reflar\Doorman\Doorkey;

class DeleteDoorkeyHandler
{
    use AssertPermissionTrait;

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

        $this->assertAdmin($actor);

        $doorkey = Doorkey::where('id', $command->doorkeyId)->firstOrFail();

        $doorkey->delete();

        return $doorkey;
    }
}
