<?php

namespace FoF\Doorman\Search;

use Flarum\Search\AbstractSearcher;
use Flarum\Search\GambitManager;
use Flarum\User\User;
use FoF\Doorman\Repository\DoorkeyRepository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Eloquent\Builder;

class DoorkeySearcher extends AbstractSearcher
{
    /**
     * @var DoorkeyRepository
     */
    protected $doorkeys;

    /**
     * @var Dispatcher
     */
    protected $events;

    public function __construct(DoorkeyRepository $doorkeys, Dispatcher $events, GambitManager $gambits, array $searchMutators)
    {
        parent::__construct($gambits, $searchMutators);

        $this->events = $events;
        $this->doorkeys = $doorkeys;
    }

    protected function getQuery(User $actor): Builder
    {
        return $this->doorkeys->query()->whereVisibleTo($actor);
    }
}
