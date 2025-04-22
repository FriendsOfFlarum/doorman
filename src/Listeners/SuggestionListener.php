<?php

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
            $event->registration->provide('fof-doorkey.bypass', true);
        }
    }
}
