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

use Flarum\Api\Controller\AbstractShowController;
use Flarum\Http\RequestUtil;
use FoF\Doorman\Api\Serializers\DoorkeySerializer;
use FoF\Doorman\Repository\DoorkeyRepository;
use Illuminate\Support\Arr;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class ShowDoorkeyController extends AbstractShowController
{
    public $serializer = DoorkeySerializer::class;

    public $include = ['group'];

    /**
     * @var DoorkeyRepository
     */
    protected $doorkeys;

    /**
     * @param DoorkeyRepository $users
     */
    public function __construct(DoorkeyRepository $doorkeys)
    {
        $this->doorkeys = $doorkeys;
    }

    /**
     * {@inheritdoc}
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        $actor = RequestUtil::getActor($request);
        $actor->assertAdmin();

        $id = Arr::get($request->getQueryParams(), 'id');

        $doorkey = $this->doorkeys->findOrFail($id, $actor);

        return $doorkey;
    }
}
