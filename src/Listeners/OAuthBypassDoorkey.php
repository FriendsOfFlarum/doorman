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

use Flarum\User\Event\RegisteringFromProvider;
use FoF\Doorman\DoorkeyBypassRegistry;

class OAuthBypassDoorkey
{
    public function __construct(protected DoorkeyBypassRegistry $registry)
    {
    }

    /**
     * @param RegisteringFromProvider $event
     */
    public function handle(RegisteringFromProvider $event): void
    {
        $provider = $event->provider;

        // Check if the provider is in the bypass list
        if ($this->registry->isProviderAllowed($provider)) {
            // Generate a unique identifier for this user
            $identifier = spl_object_hash($event->user);

            // Mark this user as exempt from doorkey validation
            $this->registry->exemptUser($identifier);

            // Store the identifier in a transient attribute that won't be saved to the database
            $event->user->doorkey_identifier = $identifier;
        }
    }
}
