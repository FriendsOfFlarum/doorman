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

namespace FoF\Doorman\Listeners;

use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\Event\Saving;
use FoF\Doorman\Doorkey;
use FoF\Doorman\DoorkeyBypassRegistry;
use FoF\Doorman\Validators\DoorkeyLoginValidator;
use Illuminate\Support\Arr;

class ValidateDoorkey
{
    protected $validator;
    protected $settings;
    protected $registry;

    public function __construct(
        DoorkeyLoginValidator $validator,
        SettingsRepositoryInterface $settings,
        DoorkeyBypassRegistry $registry
    ) {
        $this->validator = $validator;
        $this->settings = $settings;
        $this->registry = $registry;
    }

    /**
     * @param Saving $event
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function handle(Saving $event)
    {
        if (!$event->user->exists) {
            // Check if this user is exempt from doorkey validation
            if (isset($event->user->doorkey_identifier) &&
                $this->registry->isUserExempt($event->user->doorkey_identifier)) {
                // Remove the transient attribute before saving
                unset($event->user->doorkey_identifier);

                return;
            }

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

            $doorkey = Doorkey::where('key', $key)->first();

            if ($doorkey->activates) {
                $event->user->activate();
            }
        }
    }
}
