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
use Flarum\Http\UrlGenerator;
use Flarum\Query\QueryCriteria;
use FoF\Doorman\Api\Serializers\DoorkeySerializer;
use FoF\Doorman\Filter\DoorkeyFilterer;
use FoF\Doorman\Search\DoorkeySearcher;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;

class ListDoorkeysController extends AbstractListController
{
    public $serializer = DoorkeySerializer::class;

    public $include = ['group', 'createdBy'];

    /**
     * @var DoorkeyFilterer
     */
    protected $filterer;

    /**
     * @var DoorkeySearcher
     */
    protected $searcher;

    /**
     * @var UrlGenerator
     */
    protected $url;

    /**
     * @param UrlGenerator $url
     */
    public function __construct(DoorkeySearcher $searcher, DoorkeyFilterer $filterer, UrlGenerator $url)
    {
        $this->filterer = $filterer;
        $this->searcher = $searcher;
        $this->url = $url;
    }

    protected function data(ServerRequestInterface $request, Document $document)
    {
        $actor = RequestUtil::getActor($request);

        $actor->assertAdmin();

        $filters = $this->extractFilter($request);
        $sort = $this->extractSort($request);
        $sortIsDefault = $this->sortIsDefault($request);

        $limit = $this->extractLimit($request);
        $offset = $this->extractOffset($request);
        $include = $this->extractInclude($request);

        $criteria = new QueryCriteria($actor, $filters, $sort, $sortIsDefault);
        if (array_key_exists('q', $filters)) {
            $results = $this->searcher->search($criteria, $limit, $offset);
        } else {
            $results = $this->filterer->filter($criteria, $limit, $offset);
        }

        $document->addPaginationLinks(
            $this->url->to('api')->route('fof.doorkeys.index'),
            $request->getQueryParams(),
            $offset,
            $limit,
            $results->areMoreResults() ? null : 0
        );

        $results = $results->getResults();

        $this->loadRelations($results, $include, $request);

        return $results;
    }
}
