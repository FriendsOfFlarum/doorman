<?php

namespace FoF\Doorman\Provider;

use Flarum\Foundation\AbstractServiceProvider;

class DoorkeyServiceProvider extends AbstractServiceProvider
{
    public function register()
    {
        // Register an empty array of bypass providers by default
        $this->container->bind('fof-doorman.bypass_providers', function () {
            return [];
        });
    }
}
