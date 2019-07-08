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

namespace Reflar\Doorman\Listeners;

use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\Event\Saving;
use Illuminate\Contracts\Events\Dispatcher;
use Reflar\Doorman\Validators\DoorkeyLoginValidator;

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
     * @param Dispatcher $events
     *
     * @return void
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Saving::class, [$this, 'validateKey']);
    }

    /**
     * @param Saving $event
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function validateKey(Saving $event)
    {
        if (!$event->user->exists) {
            $key = strtoupper(array_get($event->data, 'attributes.reflar-doorkey'));

            // Allows the invitation key to be optional if the setting was enabled
            $allow = json_decode($this->settings->get('reflar.doorman.allowPublic'));
            if ($allow && !$key) {
                return;
            }

            $this->validator->assertValid([
                'reflar-doorkey' => $key,
            ]);
            $event->user->invite_code = $key;
        }
    }
}
