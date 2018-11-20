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
use Reflar\Doorman\Validators\DoorkeyValidator;

class EditDoorkeyHandler
{
    use AssertPermissionTrait;

    /**
     * @var DoorkeyValidator
     */
    protected $validator;

    /**
     * EditDoorkeyHandler constructor.
     *
     * @param DoorkeyValidator $validator
     */
    public function __construct(DoorkeyValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param EditRank $command
     *
     * @throws PermissionDeniedException
     *
     * @return Rank
     */
    public function handle(EditDoorkey $command)
    {
        $actor = $command->actor;
        $data = $command->data;
        $attributes = array_get($data, 'attributes', []);

        $validate = [];

        $this->assertAdmin($actor);

        $doorkey = Doorkey::where('id', $command->doorkeyId)->firstOrFail();

        if (isset($attributes['key']) && '' !== $attributes['key']) {
            $validate['key'] = strtoupper($attributes['key']);
            $doorkey->key = strtoupper($attributes['key']);
        }

        if (isset($attributes['groupId']) && '' !== $attributes['groupId']) {
            $validate['groupId'] = $attributes['groupId'];
            $doorkey->group_id = $attributes['groupId'];
        }

        if (isset($attributes['maxUses']) && '' !== $attributes['maxUses']) {
            $validate['maxUses'] = $attributes['maxUses'];
            $doorkey->max_uses = $attributes['maxUses'];
        }

        if (isset($attributes['activates']) && '' !== $attributes['activates']) {
            $validate['activates'] = $attributes['activates'];
            $doorkey->activates = $attributes['activates'];
        }

        $this->validator->assertValid(array_merge($doorkey->getDirty(), $validate));

        $doorkey->save();

        return $doorkey;
    }
}
