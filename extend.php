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

namespace FoF\Doorman;

use Flarum\Extend;
use FoF\Doorman\Api\Controllers;
use Illuminate\Contracts\Events\Dispatcher;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js')
        ->css(__DIR__.'/resources/less/forum.less'),
    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js')
        ->css(__DIR__.'/resources/less/admin.less'),
    (new Extend\Routes('api'))
        ->post('/fof/doorkeys', 'fof.doorkey.create', Controllers\CreateDoorkeyController::class)
        ->post('/fof/doorkeys/invites', 'fof.doorkey.invite', Controllers\SendInvitesController::class)
        ->delete('/fof/doorkeys/{id}', 'fof.doorkey.delete', Controllers\DeleteDoorkeyController::class)
        ->patch('/fof/doorkeys/{id}', 'fof.doorkey.update', Controllers\UpdateDoorkeyController::class)
        ->get('/fof/doorkeys', 'fof.doorkeys.index', Controllers\ListDoorkeysController::class),
    new Extend\Locales(__DIR__.'/resources/locale'),
    function (Dispatcher $dispatcher) {
        $dispatcher->subscribe(Listeners\AddValidatorRule::class);
        $dispatcher->subscribe(Listeners\ValidateDoorkey::class);
        $dispatcher->subscribe(Listeners\PostRegisterOperations::class);
        $dispatcher->subscribe(Listeners\AddAdminData::class);
        $dispatcher->subscribe(Listeners\InjectSettings::class);
    },
];
