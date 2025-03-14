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

use Flarum\User\Exception\PermissionDeniedException;
use FoF\Doorman\Doorkey;
use FoF\Doorman\Events\DoorkeyCreated;
use FoF\Doorman\Validators\DoorkeyValidator;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Arr;

class CreateDoorkeyHandler
{
    /**
     * @var DoorkeyValidator
     */
    protected $validator;

    /**
     * @var Dispatcher
     */
    protected $events;

    /**
     * @param DoorkeyValidator $validator
     */
    public function __construct(DoorkeyValidator $validator, Dispatcher $events)
    {
        $this->validator = $validator;
        $this->events = $events;
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

        $doorkey->afterSave(function ($doorkey) use ($actor, $data) {
            $this->events->dispatch(
                new DoorkeyCreated($doorkey, $actor, $data)
            );
        });

        return $doorkey;
    }
}
