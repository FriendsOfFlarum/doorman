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
use FoF\Doorman\DoorkeyBypassRegistry;
use FoF\Doorman\Repository\DoorkeyRepository;
use FoF\Doorman\Validators\DoorkeyLoginValidator;
use Illuminate\Support\Arr;

class ValidateDoorkey
{
    public function __construct(protected DoorkeyLoginValidator $validator, protected SettingsRepositoryInterface $settings, protected DoorkeyBypassRegistry $registry, protected DoorkeyRepository $doorkeys)
    {
    }

    /**
     * @param Saving $event
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function handle(Saving $event): void
    {
        if (!$event->user->exists) {
            // Check if this user is exempt from doorkey validation
            if (isset($event->user->doorkey_identifier) &&
                $this->registry->isUserExempt($event->user->doorkey_identifier)) {
                // Remove the transient attribute before saving
                unset($event->user->doorkey_identifier);

                return;
            }

            $key = strtoupper(trim((string) Arr::get($event->data, 'attributes.fof-doorkey')));

            // Allows the invitation key to be optional if the setting was enabled
            $allow = json_decode($this->settings->get('fof-doorman.allowPublic'));
            if ($allow && !$key) {
                return;
            }

            $this->validator->assertValid([
                'fof-doorkey' => $key,
            ]);
            $event->user->invite_code = $key;

            $doorkey = $this->doorkeys->getByKey($key);

            if ($doorkey && $doorkey->activates) {
                $event->user->activate();
            }
        }
    }
}
