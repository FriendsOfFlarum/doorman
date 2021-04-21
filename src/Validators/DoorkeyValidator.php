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

namespace FoF\Doorman\Validators;

use Flarum\Foundation\AbstractValidator;

class DoorkeyValidator extends AbstractValidator
{
    protected $translator;

    /**
     * {@inheritdoc}
     */
    protected $rules = [
        'key' => [
            'required',
            'string',
            'unique:doorkeys,key',
        ],
        'group_id' => [
            'required',
            'exists:groups,id',
        ],
        'max_uses' => [
            'numeric',
            'min:0',
        ],
        'activates' => [
            'boolean',
        ],
    ];
}
