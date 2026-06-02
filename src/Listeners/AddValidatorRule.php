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

use Flarum\Foundation\AbstractValidator;
use Flarum\Settings\SettingsRepositoryInterface;
use FoF\Doorman\Repository\DoorkeyRepository;
use Illuminate\Validation\Validator;

class AddValidatorRule
{
    public function __construct(protected SettingsRepositoryInterface $settings, protected DoorkeyRepository $doorkeys)
    {
    }

    public function __invoke(AbstractValidator $flarumValidator, Validator $validator)
    {
        $validator->addExtension(
            'doorkey',
            function ($attribute, $value, $parameters) {
                $doorkey = $this->doorkeys->getByKey((string) $value);

                // Allows the invitation key to be optional if the setting was enabled
                $allow = json_decode($this->settings->get('fof-doorman.allowPublic'));
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
