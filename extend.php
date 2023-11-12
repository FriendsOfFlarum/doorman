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

namespace FoF\Doorman;

use Flarum\Api\Controller\ShowForumController;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Extend;
use Flarum\User\Event\Registered;
use Flarum\User\Event\Saving as UserSaving;
use Flarum\User\User;
use FoF\Doorman\Api\Controllers;
use FoF\Doorman\Api\Serializers\DoorkeySerializer;
use FoF\Doorman\Validators\DoorkeyLoginValidator;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js')
        ->css(__DIR__.'/resources/less/forum.less'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js')
        ->css(__DIR__.'/resources/less/admin.less'),

    (new Extend\Model(User::class))
        ->cast('invite_code', 'string'),

    (new Extend\Routes('api'))
        ->post('/fof/doorkeys', 'fof.doorkey.create', Controllers\CreateDoorkeyController::class)
        ->post('/fof/doorkeys/invites', 'fof.doorkey.invite', Controllers\SendInvitesController::class)
        ->delete('/fof/doorkeys/{id}', 'fof.doorkey.delete', Controllers\DeleteDoorkeyController::class)
        ->patch('/fof/doorkeys/{id}', 'fof.doorkey.update', Controllers\UpdateDoorkeyController::class)
        ->get('/fof/doorkeys', 'fof.doorkeys.index', Controllers\ListDoorkeysController::class),

    new Extend\Locales(__DIR__.'/resources/locale'),

    (new Extend\Validator(DoorkeyLoginValidator::class))
        ->configure(Listeners\AddValidatorRule::class),

    (new Extend\Settings())
        ->serializeToForum('fof-doorman.allowPublic', 'fof-doorman.allowPublic', 'boolVal', false),

    (new Extend\Event())
        ->listen(Registered::class, Listeners\PostRegisterOperations::class)
        ->listen(UserSaving::class, Listeners\ValidateDoorkey::class),
];
