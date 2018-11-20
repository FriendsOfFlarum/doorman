<?php

/**
 *  This file is part of reflar/doorman.
 *
 *  Copyright (c) 2018 ReFlar.
 *
 *  https://reflar.redevs.org
 *
 *  For the full copyright and license information, please view the LICENSE.md
 *  file that was distributed with this source code.
 */

namespace Reflar\Doorman\Commands;

use Flarum\User\AssertPermissionTrait;
use Flarum\User\Exception\PermissionDeniedException;
use Reflar\Doorman\Doorkey;
use Reflar\Doorman\Validators\DoorkeyValidator;

class CreateDoorkeyHandler
{
    use AssertPermissionTrait;

    /**
     * @var DoorkeyValidator
     */
    protected $validator;

    /**
     * @param DoorkeyValidator $validator
     */
    public function __construct(DoorkeyValidator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param CreateDoorkey $command
     *
     * @throws PermissionDeniedException
     * @throws \Illuminate\Validation\ValidationException
     *
     * @return Doorkey
     */
    public function handle(CreateDoorkey $command)
    {
        $actor = $command->actor;
        $data = $command->data;

        $this->assertAdmin($actor);

        $doorkey = Doorkey::build(
            array_get($data, 'attributes.key'),
            array_get($data, 'attributes.groupId'),
            array_get($data, 'attributes.maxUses'),
            array_get($data, 'attributes.activates')
        );

        $this->validator->assertValid($doorkey->getAttributes());

        $doorkey->save();

        return $doorkey;
    }
}
