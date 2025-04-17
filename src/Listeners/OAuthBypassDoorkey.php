<?php

/*
 * This file is part of fof/doorman.
 *
 * Copyright (c) Reflar.
 * Copyright (c) FriendsOfFlarum.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FoF\Doorman\Listeners;

use Flarum\User\Event\RegisteringFromProvider;
use FoF\Doorman\DoorkeyBypassRegistry;

class OAuthBypassDoorkey
{
    /**
     * @param RegisteringFromProvider $event
     */
    public function handle(RegisteringFromProvider $event)
    {
        $provider = $event->provider;
        
        // Get the list of providers that can bypass doorkey from the container
        $bypassProviders = resolve('fof-doorman.bypass_providers');
        
        // Check if the provider is in the bypass list
        if (in_array($provider, $bypassProviders)) {
            // Generate a unique identifier for this user
            $identifier = spl_object_hash($event->user);
            
            // Mark this user as exempt from doorkey validation
            DoorkeyBypassRegistry::exemptUser($identifier);
            
            // Store the identifier in a transient attribute that won't be saved to the database
            $event->user->doorkey_identifier = $identifier;
        }
    }
}
