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

namespace FoF\Doorman\Listeners;

use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\Event\Saving;
use FoF\Doorman\Validators\DoorkeyLoginValidator;
use Illuminate\Support\Arr;

class ValidateDoorkey
{
    protected $validator;
    protected $settings;

    public function __construct(DoorkeyLoginValidator $validator, SettingsRepositoryInterface $settings)
    {
        $this->validator = $validator;
        $this->settings = $settings;
    }

    /**
     * @param Saving $event
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function handle(Saving $event)
    {
        if (!$event->user->exists) {
            $key = strtoupper(Arr::get($event->data, 'attributes.fof-doorkey'));

            // Allows the invitation key to be optional if the setting was enabled
            $allow = json_decode($this->settings->get('fof-doorman.allowPublic'));
            if ($allow && !$key) {
                return;
            }

            $this->validator->assertValid([
                'fof-doorkey' => $key,
            ]);
            $event->user->invite_code = $key;
        }
    }
}
