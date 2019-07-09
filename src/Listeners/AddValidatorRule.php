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

use Flarum\Foundation\Event\Validating;
use Flarum\Settings\SettingsRepositoryInterface;
use Illuminate\Contracts\Events\Dispatcher;
use Reflar\Doorman\Doorkey;
use Reflar\Doorman\Validators\DoorkeyLoginValidator;

class AddValidatorRule
{
    protected $settings;

    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    /**
     * @param Dispatcher $events
     *
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

                    // Allows the invitation key to be optional if the setting was enabled
                    $allow = json_decode($this->settings->get('reflar.doorman.allowPublic'));
                    if ($allow && !$doorkey) {
                        return;
                    }

                    if ($doorkey !== null && ($doorkey->max_uses === 0 || $doorkey->uses < $doorkey->max_uses)) {
                        return true;
                    } else {
                        return false;
                    }
                }
            );
        }
    }
}
