<?php

/**
 *  This file is part of reflar/doorman.
 *
 *  Copyright (c) 2018 .
 *
 *
 *  For the full copyright and license information, please view the LICENSE.md
 *  file that was distributed with this source code.
 */

namespace Reflar\Doorman\Validators;

use Flarum\Foundation\AbstractValidator;

class DoorkeyLoginValidator extends AbstractValidator
{
    protected $translator;

    /**
     * {@inheritdoc}
     */
    protected $rules = [
        'key' => [
            'required',
            'string',
        ],
        'group_id' => [
            'required',
            'exists:group,id'
        ],
        'max_uses' => [
            'nullable',
            'numeric',
            'min:0'
        ],
        'activates' => [
            'boolean'
        ],
    ];
}
