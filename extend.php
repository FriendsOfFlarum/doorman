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
use Flarum\Search\Database\DatabaseSearchDriver;
use Flarum\User\Event\Registered;
use Flarum\User\Event\RegisteringFromProvider;
use Flarum\User\Event\Saving as UserSaving;
use Flarum\User\User;
use FoF\Doorman\Content\AdminPayload;
use FoF\Doorman\Provider\DoorkeyServiceProvider;
use FoF\Doorman\Search\CreatedByFilter;
use FoF\Doorman\Search\DoorkeySearcher;
use FoF\Doorman\Search\FulltextFilter;
use FoF\Doorman\Validators\DoorkeyLoginValidator;
use FoF\OAuth\Events\SettingSuggestions;

return [
    (new Extend\Frontend('forum'))
        ->js(__DIR__.'/js/dist/forum.js'),

    (new Extend\Frontend('admin'))
        ->js(__DIR__.'/js/dist/admin.js')
        ->jsDirectory(__DIR__.'/js/dist/admin')
        ->css(__DIR__.'/resources/less/admin.less')
        ->content(AdminPayload::class),

    (new Extend\Model(User::class))
        ->cast('doorkey_identifier', 'string')
        ->cast('invite_code', 'string')
        ->cast('fofDoorkeyBypass', 'string'),

    (new Extend\SearchDriver(DatabaseSearchDriver::class))
        ->addSearcher(Doorkey::class, DoorkeySearcher::class)
        ->setFulltext(DoorkeySearcher::class, FulltextFilter::class)
        ->addFilter(DoorkeySearcher::class, CreatedByFilter::class),

    new Extend\Locales(__DIR__.'/resources/locale'),

    (new Extend\Validator(DoorkeyLoginValidator::class))
        ->configure(Listeners\AddValidatorRule::class),

    (new Extend\Settings())
        ->default('fof-doorman.allowPublic', false)
        ->serializeToForum('fof-doorman.allowPublic', 'fof-doorman.allowPublic', 'boolVal'),

    (new Extend\Event())
        ->listen(Registered::class, Listeners\PostRegisterOperations::class)
        ->listen(UserSaving::class, Listeners\ValidateDoorkey::class)
        ->listen(RegisteringFromProvider::class, Listeners\OAuthBypassDoorkey::class)
        ->listen(SettingSuggestions::class, Listeners\SuggestionListener::class)
        ->listen(UserSaving::class, Listeners\ClearBypass::class),

    (new Extend\ServiceProvider())
        ->register(DoorkeyServiceProvider::class),

    new Extend\ApiResource(Api\Resource\DoorkeyResource::class),
];
