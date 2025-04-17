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

namespace FoF\Doorman\Extend;

use Flarum\Extend\ExtenderInterface;
use Flarum\Extension\Extension;
use FoF\Doorman\DoorkeyBypassRegistry;
use Illuminate\Contracts\Container\Container;

class BypassDoorkey implements ExtenderInterface
{
    private $providers = [];

    /**
     * Allow users registering through the specified OAuth provider to bypass doorkey requirements.
     *
     * @param string $providerName The name of the OAuth provider
     * @return self
     */
    public function forProvider(string $providerName): self
    {
        $this->providers[] = $providerName;

        return $this;
    }

    public function extend(Container $container, Extension $extension = null)
    {
        // Get the existing providers from the container
        $existingProviders = $container->make('fof-doorman.bypass_providers');
        
        // Register each provider with the registry
        foreach ($this->providers as $provider) {
            if (!in_array($provider, $existingProviders)) {
                $existingProviders[] = $provider;
                DoorkeyBypassRegistry::registerProvider($provider);
            }
        }
        
        // Update the container binding with the new list
        $container->instance('fof-doorman.bypass_providers', $existingProviders);
    }
}
