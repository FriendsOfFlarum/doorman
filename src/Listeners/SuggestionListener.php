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

use FoF\Doorman\DoorkeyBypassRegistry;
use FoF\OAuth\Events\SettingSuggestions;

class SuggestionListener
{
    /**
     * @var DoorkeyBypassRegistry
     */
    protected $registry;

    public function __construct(DoorkeyBypassRegistry $registry)
    {
        $this->registry = $registry;
    }

    public function handle(SettingSuggestions $event)
    {
        if ($this->registry->isProviderAllowed($event->provider)) {
            $event->registration->provide('fofDoorkeyBypass', true);
        }
    }
}
