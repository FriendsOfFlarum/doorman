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
use Reflar\Doorman\Api\Controllers;
use Illuminate\Contracts\Bus\Dispatcher;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js')
        ->css(__DIR__.'/resources/less/forum.less'),
    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js')
        ->css(__DIR__.'/resources/less/admin.less'),
    (new Extend\Routes('api'))
        ->post('/reflar/doorkeys', 'reflar.doorkey.create', Controllers\CreateDoorkeyController::class)
        ->get('/reflar/doorkeys', 'reflar.doorkeys.index', Controllers\ListDoorkeysController::class),
    new Extend\Locales(__DIR__ . '/resources/locale'),
    function (Dispatcher $dispatcher) {
        $dispatcher->pipeThrough(['Reflar\Doorman\Verify']);
    },
];
