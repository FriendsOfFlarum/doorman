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

namespace Reflar\Doorman\Commands;

use Flarum\User\Exception\PermissionDeniedException;
use Illuminate\Support\Arr;
use Reflar\Doorman\Doorkey;
use Reflar\Doorman\Validators\DoorkeyValidator;

class CreateDoorkeyHandler
{
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

        $actor->assertAdmin();

        $doorkey = Doorkey::build(
            Arr::get($data, 'attributes.key'),
            Arr::get($data, 'attributes.groupId'),
            Arr::get($data, 'attributes.maxUses'),
            Arr::get($data, 'attributes.activates')
        );

        $this->validator->assertValid($doorkey->getAttributes());

        $doorkey->save();

        return $doorkey;
    }
}
