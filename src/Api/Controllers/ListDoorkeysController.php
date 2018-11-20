<?php

/**
 *  This file is part of reflar/doorman.
 *
 *  Copyright (c) 2018 ReFlar.
 *
 *  https://reflar.redevs.org
 *
 *  For the full copyright and license information, please view the LICENSE.md
 *  file that was distributed with this source code.
 */

namespace Reflar\Doorman\Api\Controllers;

use Flarum\Api\Controller\AbstractListController;
use Flarum\User\AssertPermissionTrait;
use Psr\Http\Message\ServerRequestInterface;
use Reflar\Doorman\Api\Serializers\DoorkeySerializer;
use Reflar\Doorman\Doorkey;
use Tobscure\JsonApi\Document;

class ListDoorkeysController extends AbstractListController
{
    use AssertPermissionTrait;

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
        $this->assertAdmin($request->getAttribute('actor'));

        return Doorkey::all();
    }
}
