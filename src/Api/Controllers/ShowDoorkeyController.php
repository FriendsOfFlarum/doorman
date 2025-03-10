<?php

namespace FoF\Doorman\Api\Controllers;

use Flarum\Api\Controller\AbstractShowController;
use FoF\Doorman\Api\Serializers\DoorkeySerializer;
use FoF\Doorman\Repository\DoorkeyRepository;
use Psr\Http\Message\ServerRequestInterface;
use Tobscure\JsonApi\Document;
use Illuminate\Support\Arr;
use Flarum\Http\RequestUtil;

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