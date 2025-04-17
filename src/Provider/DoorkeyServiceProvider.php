<?php

namespace FoF\Doorman\Provider;

use Flarum\Foundation\AbstractServiceProvider;
use FoF\Doorman\DoorkeyBypassRegistry;

class DoorkeyServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        // Register an empty array of bypass providers by default
        $this->container->bind('fof-doorman.bypass_providers', function () {
            return [];
        });
        
        // Register an empty array for exempt users
        $this->container->bind('fof-doorman.exempt_users', function () {
            return [];
        });
        
        // Register the DoorkeyBypassRegistry as a singleton
        $this->container->singleton(DoorkeyBypassRegistry::class, function ($container) {
            return new DoorkeyBypassRegistry($container);
        });
    }
}
