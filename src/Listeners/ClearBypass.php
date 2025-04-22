<?php

namespace FoF\Doorman\Listeners;

use Flarum\User\Event\Saving;
use Illuminate\Support\Arr;

class ClearBypass
{
    public function handle(Saving $event)
    {
        if ($event->user->fofDoorkeyBypass) {
            unset($event->user->fofDoorkeyBypass);
        }
    }
}
