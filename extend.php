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

use Flarum\Extend;
use Flarum\User\Event\Registered;
use Flarum\User\Event\RegisteringFromProvider;
use Flarum\User\Event\Saving as UserSaving;
use Flarum\User\User;
use FoF\Doorman\Api\Controllers;
use FoF\Doorman\Content\AdminPayload;
use FoF\Doorman\Filter\CreatedByFilterGambit;
use FoF\Doorman\Filter\DoorkeyFilterer;
use FoF\Doorman\Provider\DoorkeyServiceProvider;
use FoF\Doorman\Search\DoorkeySearcher;
use FoF\Doorman\Search\Gambit\FulltextGambit;
use FoF\Doorman\Validators\DoorkeyLoginValidator;
use FoF\OAuth\Events\SettingSuggestions;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js')
        ->css(__DIR__.'/resources/less/admin.less')
        ->content(AdminPayload::class),

    (new Extend\Model(User::class))
        ->cast('doorkey_identifier', 'string')
        ->cast('invite_code', 'string'),

    (new Extend\Routes('api'))
        ->post('/fof/doorkeys', 'fof.doorkey.create', Controllers\CreateDoorkeyController::class)
        ->post('/fof/doorkeys/invites', 'fof.doorkey.invite', Controllers\SendInvitesController::class)
        ->delete('/fof/doorkeys/{id}', 'fof.doorkey.delete', Controllers\DeleteDoorkeyController::class)
        ->patch('/fof/doorkeys/{id}', 'fof.doorkey.update', Controllers\UpdateDoorkeyController::class)
        ->get('/fof/doorkeys', 'fof.doorkeys.index', Controllers\ListDoorkeysController::class)
        ->get('/fof/doorkeys/{id}', 'fof.doorkeys.show', Controllers\ShowDoorkeyController::class),

    (new Extend\SimpleFlarumSearch(DoorkeySearcher::class))
        ->addGambit(CreatedByFilterGambit::class)
        ->setFullTextGambit(FulltextGambit::class),

    (new Extend\Filter(DoorkeyFilterer::class))
        ->addFilter(CreatedByFilterGambit::class),

    new Extend\Locales(__DIR__.'/resources/locale'),

    (new Extend\Validator(DoorkeyLoginValidator::class))
        ->configure(Listeners\AddValidatorRule::class),

    (new Extend\Settings())
        ->serializeToForum('fof-doorman.allowPublic', 'fof-doorman.allowPublic', 'boolVal', false),

    (new Extend\Event())
        ->listen(Registered::class, Listeners\PostRegisterOperations::class)
        ->listen(UserSaving::class, Listeners\ValidateDoorkey::class)
        ->listen(RegisteringFromProvider::class, Listeners\OAuthBypassDoorkey::class)
        ->listen(SettingSuggestions::class, Listeners\SuggestionListener::class)
        ->listen(UserSaving::class, Listeners\ClearBypass::class),

    (new Extend\ServiceProvider())
        ->register(DoorkeyServiceProvider::class),
];
