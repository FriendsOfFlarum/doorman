<?php
/**
 *  This file is part of reflar/doorman.
 *
 *  Copyright (c) 2018 ReFlar.
 *
 *  https://reflar.redevs.org
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Reflar\Doorman\Listeners;

use Illuminate\Contracts\Events\Dispatcher;
use Flarum\Foundation\Event\Validating;
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
     * @param Validating $event
     */
    public function addRule(Validating $event)
    {
        if ($event->type instanceof DoorkeyLoginValidator) {
            $event->validator->addExtension(
                'doorkey',
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