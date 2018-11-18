<?php

/**
 *  This file is part of reflar/doorman.
 *
 *  Copyright (c) 2018 .
 *
 *
 *  For the full copyright and license information, please view the LICENSE.md
 *  file that was distributed with this source code.
 */

namespace Reflar\Doorman;

use Illuminate\Contracts\Events\Dispatcher;
use Flarum\User\Command\RegisterUser;

class Verify
{
    /**
     * @var UserValidator
     */
    protected $validator;

    /**
     * @param UserValidator $validator
     */
    public function __construct(RecaptchaValidator $validator)
    {
        $this->validator = $validator;
    }

    public function handle($command, $next)
    {
        if ($command instanceof RegisterUser) {
            $this->validator->assertValid([
                'reflar-doorman' => array_get($command->data, 'attributes.reflar-doorman')
            ]);
        }
        return $next($command);
    }
}
