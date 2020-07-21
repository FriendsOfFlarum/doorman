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

use Flarum\Extend;
use Illuminate\Contracts\Events\Dispatcher;
use Reflar\Doorman\Api\Controllers;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js')
        ->css(__DIR__.'/resources/less/forum.less'),
    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js')
        ->css(__DIR__.'/resources/less/admin.less'),
    (new Extend\Routes('api'))
        ->post('/reflar/doorkeys', 'reflar.doorkey.create', Controllers\CreateDoorkeyController::class)
        ->post('/reflar/doorkeys/invites', 'reflar.doorkey.invite', Controllers\SendInvitesController::class)
        ->delete('/reflar/doorkeys/{id}', 'reflar.doorkey.delete', Controllers\DeleteDoorkeyController::class)
        ->patch('/reflar/doorkeys/{id}', 'reflar.doorkey.update', Controllers\UpdateDoorkeyController::class)
        ->get('/reflar/doorkeys', 'reflar.doorkeys.index', Controllers\ListDoorkeysController::class),
    new Extend\Locales(__DIR__.'/resources/locale'),
    function (Dispatcher $dispatcher) {
        $dispatcher->subscribe(Listeners\AddValidatorRule::class);
        $dispatcher->subscribe(Listeners\ValidateDoorkey::class);
        $dispatcher->subscribe(Listeners\PostRegisterOperations::class);
        $dispatcher->subscribe(Listeners\AddAdminData::class);
        $dispatcher->subscribe(Listeners\InjectSettings::class);
    },
];
