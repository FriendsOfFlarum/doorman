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
        'reflar-doorkey' => [
            'required',
            'doorkey',
        ],
    ];

    /**
     * {@inheritdoc}
     */
    protected function getMessages()
    {
        $translator = app('translator');

        return [
            'doorkey'  => $translator->trans('reflar-doorman.forum.sign_up.invalid_doorkey'),
            'required' => $translator->trans('reflar-doorman.forum.sign_up.doorkey_required'),
        ];
    }
}
