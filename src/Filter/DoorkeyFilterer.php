<?php

namespace FoF\Doorman\Filter;

use Flarum\Filter\AbstractFilterer;
use Flarum\User\User;
use FoF\Doorman\Repository\DoorkeyRepository;
use Illuminate\Database\Eloquent\Builder;

class DoorkeyFilterer extends AbstractFilterer
{
    /**
     * @var DoorkeyRepository
     */
    protected $doorkeys;

    /**
     * @param DoorkeyRepository $doorkeys
     * @param array $filters
     * @param array $filterMutators
     */
    public function __construct(DoorkeyRepository $doorkeys, array $filters, array $filterMutators)
    {
        parent::__construct($filters, $filterMutators);

        $this->doorkeys = $doorkeys;
    }

    protected function getQuery(User $actor): Builder
    {
        return $this->doorkeys->query();
    }
}
