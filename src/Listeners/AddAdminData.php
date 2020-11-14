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

use Flarum\Api\Controller\ShowForumController;
use Flarum\Api\Event\WillGetData;
use Flarum\Api\Event\WillSerializeData;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Event\GetApiRelationship;
use FoF\Doorman\Api\Serializers\DoorkeySerializer;
use FoF\Doorman\Doorkey;
use Illuminate\Contracts\Events\Dispatcher;

class AddAdminData
{
    /**
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(WillSerializeData::class, [$this, 'loadDoorkeysRelationship']);
        $events->listen(GetApiRelationship::class, [$this, 'getApiAttributes']);
        $events->listen(WillGetData::class, [$this, 'includeDoorkeys']);
    }

    /**
     * @param GetApiRelationship $event
     *
     * @return \Tobscure\JsonApi\Relationship|null
     */
    public function getApiAttributes(GetApiRelationship $event)
    {
        if ($event->isRelationship(ForumSerializer::class, 'doorkeys')) {
            return $event->serializer->hasMany($event->model, DoorkeySerializer::class, 'doorkeys');
        }
    }

    /**
     * @param WillSerializeData $event
     */
    public function loadDoorkeysRelationship(WillSerializeData $event)
    {
        if ($event->isController(ShowForumController::class)) {
            if ($event->actor->isAdmin()) {
                $event->data['doorkeys'] = Doorkey::all();
            } else {
                $event->data['doorkeys'] = [];
            }
        }
    }

    /**
     * @param WillGetData $event
     */
    public function includeDoorkeys(WillGetData $event)
    {
        if ($event->isController(ShowForumController::class)) {
            $event->addInclude('doorkeys');
        }
    }
}
