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

use Flarum\Api\Controller\ShowForumController;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Extend;
use Flarum\User\Event\Registered;
use Flarum\User\Event\Saving as UserSaving;
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

    (new Extend\Routes('api'))
        ->post('/fof/doorkeys', 'fof.doorkey.create', Controllers\CreateDoorkeyController::class)
        ->post('/fof/doorkeys/invites', 'fof.doorkey.invite', Controllers\SendInvitesController::class)
        ->delete('/fof/doorkeys/{id}', 'fof.doorkey.delete', Controllers\DeleteDoorkeyController::class)
        ->patch('/fof/doorkeys/{id}', 'fof.doorkey.update', Controllers\UpdateDoorkeyController::class)
        ->get('/fof/doorkeys', 'fof.doorkeys.index', Controllers\ListDoorkeysController::class),

    new Extend\Locales(__DIR__.'/resources/locale'),

    (new Extend\ApiSerializer(ForumSerializer::class))
        ->hasMany('doorkeys', DoorkeySerializer::class),

    (new Extend\ApiController(ShowForumController::class))
        ->prepareDataForSerialization(Listeners\AddAdminData::class)
        ->addInclude('doorkeys'),

    (new Extend\Validator(DoorkeyLoginValidator::class))
        ->configure(Listeners\AddValidatorRule::class),

    (new Extend\Settings())
        ->serializeToForum('fof-doorman.allowPublic', 'fof-doorman.allowPublic'),

    (new Extend\Event())
        ->listen(Registered::class, Listeners\PostRegisterOperations::class)
        ->listen(UserSaving::class, Listeners\ValidateDoorkey::class),
];
