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

namespace FoF\Doorman;

class DoorkeyBypassRegistry
{
    /**
     * @var array
     */
    private static $bypassProviders = [];
    
    /**
     * @var array
     */
    private static $exemptUsers = [];

    /**
     * Register a provider that can bypass doorkey requirements.
     *
     * @param string $provider
     */
    public static function registerProvider(string $provider): void
    {
        if (!in_array($provider, self::$bypassProviders)) {
            self::$bypassProviders[] = $provider;
        }
    }

    /**
     * Check if a provider is allowed to bypass doorkey requirements.
     *
     * @param string $provider
     * @return bool
     */
    public static function isProviderAllowed(string $provider): bool
    {
        return in_array($provider, self::$bypassProviders);
    }
    
    /**
     * Mark a user as exempt from doorkey validation.
     *
     * @param string $identifier A unique identifier for the user
     */
    public static function exemptUser(string $identifier): void
    {
        self::$exemptUsers[$identifier] = true;
    }
    
    /**
     * Check if a user is exempt from doorkey validation.
     *
     * @param string $identifier A unique identifier for the user
     * @return bool
     */
    public static function isUserExempt(string $identifier): bool
    {
        return isset(self::$exemptUsers[$identifier]) && self::$exemptUsers[$identifier] === true;
    }
}
