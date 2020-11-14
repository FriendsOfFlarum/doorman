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

namespace FoF\Doorman\Api\Controllers;

use Flarum\Api\Controller\AbstractListController;
use Flarum\User\User;
use Psr\Http\Message\ServerRequestInterface;
use FoF\Doorman\Api\Serializers\DoorkeySerializer;
use FoF\Doorman\Doorkey;
use Tobscure\JsonApi\Document;

class ListDoorkeysController extends AbstractListController
{
    /**
     * @var DoorkeySerializer
     */
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
        /**
         * @var User
         */
        $actor = $request->getAttribute('actor');
        $actor->assertAdmin();

        return Doorkey::all();
    }
}
