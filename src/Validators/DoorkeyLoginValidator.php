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

class DoorkeyLoginValidator extends AbstractValidator
{
    protected $translator;

    /**
     * {@inheritdoc}
     */
    protected $rules = [
        'fof-doorkey' => [
            'required',
            'doorkey',
        ],
    ];

    /**
     * {@inheritdoc}
     */
    protected function getMessages()
    {
        $translator = resolve('translator');

        return [
            'doorkey'  => $translator->trans('fof-doorman.forum.sign_up.invalid_doorkey'),
            'required' => $translator->trans('fof-doorman.forum.sign_up.doorkey_required'),
        ];
    }
}
