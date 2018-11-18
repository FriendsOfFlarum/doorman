<?php

/**
 *  This file is part of reflar/doorman.
 *
 *  Copyright (c) 2018 ReFlar.
 *
 *  https://reflar.redevs.org
 *
 *  For the full copyright and license information, please view the LICENSE.md
 *  file that was distributed with this source code.
 */

namespace Reflar\Doorman\Listeners;

use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Bus\Dispatcher as BusDispatcher;
use Flarum\User\Command\RegisterUser;
use Flarum\User\UserValidator;
use Flarum\Foundation\Event\Validating;
use Flarum\Settings\SettingsRepositoryInterface;
use Reflar\Doorman\Doorkey;
use Reflar\Doorman\Validators\DoorkeyLoginValidator;

class AddValidatorRule
{

    /**
     * @param Dispatcher $events
     * @return void
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(Validating::class, [$this, 'addRule']);
    }

    /**
     * @param ConfigureValidator $event
     * @return void
     */
    public function addRule(ConfigureValidator $event)
    {
        if ($event->type instanceof DoorkeyLoginValidator) {
            $event->validator->addExtension(
                'reflar-doorkey',
                function ($attribute, $value, $parameters) {
                    $doorkey = Doorkey::where('key', $value)->first();
                    if ($doorkey !== null && ($doorkey->max_uses === null || $doorkey->uses < $doorkey->max_uses)) {
                        return true;
                    } else {
                        return false;
                    }
                }
            );
        }
    }
}
