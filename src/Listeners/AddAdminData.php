<?php
/**
 *  This file is part of reflar/doorman.
 *
 *  Copyright (c) 2018 ReFlar.
 *
 *  https://reflar.redevs.org
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace Reflar\Doorman\Listeners;

use Flarum\Api\Controller\ShowForumController;
use Flarum\Api\Event\WillGetData;
use Flarum\Api\Event\WillSerializeData;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Event\GetApiRelationship;
use Illuminate\Contracts\Events\Dispatcher;
use Reflar\Doorman\Api\Serializers\DoorkeySerializer;
use Reflar\Doorman\Doorkey;

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
