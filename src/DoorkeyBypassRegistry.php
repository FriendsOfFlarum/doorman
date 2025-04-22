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

namespace FoF\Doorman;

use Illuminate\Contracts\Container\Container;

class DoorkeyBypassRegistry
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Register a provider that can bypass doorkey requirements.
     *
     * @param string $provider
     */
    public function registerProvider(string $provider): void
    {
        $providers = $this->container->make('fof-doorman.bypass_providers');

        if (!in_array($provider, $providers)) {
            $providers[] = $provider;
            $this->container->instance('fof-doorman.bypass_providers', $providers);
        }
    }

    /**
     * Check if a provider is allowed to bypass doorkey requirements.
     *
     * @param string $provider
     *
     * @return bool
     */
    public function isProviderAllowed(string $provider): bool
    {
        $providers = $this->container->make('fof-doorman.bypass_providers');

        return in_array($provider, $providers);
    }

    /**
     * Mark a user as exempt from doorkey validation.
     *
     * @param string $identifier A unique identifier for the user
     */
    public function exemptUser(string $identifier): void
    {
        $exemptUsers = $this->container->bound('fof-doorman.exempt_users')
            ? $this->container->make('fof-doorman.exempt_users')
            : [];

        $exemptUsers[$identifier] = true;
        $this->container->instance('fof-doorman.exempt_users', $exemptUsers);
    }

    /**
     * Check if a user is exempt from doorkey validation.
     *
     * @param string $identifier A unique identifier for the user
     *
     * @return bool
     */
    public function isUserExempt(string $identifier): bool
    {
        $exemptUsers = $this->container->bound('fof-doorman.exempt_users')
            ? $this->container->make('fof-doorman.exempt_users')
            : [];

        return isset($exemptUsers[$identifier]) && $exemptUsers[$identifier] === true;
    }
}
