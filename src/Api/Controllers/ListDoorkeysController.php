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

namespace FoF\Doorman\Api\Controllers;

use Flarum\Api\Controller\AbstractListController;
use Flarum\Http\RequestUtil;
use FoF\Doorman\Api\Serializers\DoorkeySerializer;
use FoF\Doorman\Doorkey;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class ListDoorkeysController extends AbstractListController
{
    public $serializer = DoorkeySerializer::class;

    /**
     * @param ServerRequestInterface $request
     * @param Document               $document
     *
     * @throws \Flarum\User\Exception\PermissionDeniedException
     *
     * @return \Illuminate\Database\Eloquent\Collection|mixed|Doorkey[]
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        RequestUtil::getActor($request)->assertAdmin();

        return Doorkey::all();
    }
}
