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

use FoF\Doorman\Doorkey;
use FoF\Doorman\Events\DoorkeyUpdating;
use FoF\Doorman\Validators\DoorkeyValidator;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Arr;

class EditDoorkeyHandler
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
     * EditDoorkeyHandler constructor.
     *
     * @param DoorkeyValidator $validator
     */
    public function __construct(DoorkeyValidator $validator, Dispatcher $events)
    {
        $this->validator = $validator;
        $this->events = $events;
    }

    /**
     * @param EditDoorkey $command
     *
     * @return Doorkey
     */
    public function handle(EditDoorkey $command)
    {
        $data = $command->data;
        $attributes = Arr::get($data, 'attributes', []);

        $validate = [];

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

        $actor = $command->actor;

        $this->events->dispatch(
            new DoorkeyUpdating($doorkey, $actor, $data)
        );

        $this->validator->assertValid(array_merge($doorkey->getDirty(), $validate));

        $doorkey->save();

        return $doorkey;
    }
}
