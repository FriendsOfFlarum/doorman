<?php

/*
 * This file is part of fof/doorman.
 *
 * Copyright (c) 2018-2020 Reflar.
 * Copyright (c) 2020 FriendsOfFlarum
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 *
 */

namespace FoF\Doorman\Listeners;

use Flarum\Foundation\AbstractValidator;
use Flarum\Settings\SettingsRepositoryInterface;
use FoF\Doorman\Doorkey;
use Illuminate\Validation\Validator;

class AddValidatorRule
{
    protected $settings;

    public function __construct(SettingsRepositoryInterface $settings)
    {
        $this->settings = $settings;
    }

    public function __invoke(AbstractValidator $flarumValidator, Validator $validator)
    {
        $validator->addExtension(
            'doorkey',
            function ($attribute, $value, $parameters) {
                $doorkey = Doorkey::where('key', $value)->first();

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
