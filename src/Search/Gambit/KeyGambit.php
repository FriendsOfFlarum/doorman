<?php

namespace FoF\Doorman\Search\Gambit;

use Flarum\Search\GambitInterface;
use Flarum\Search\SearchState;
use FoF\Doorman\Repository\DoorkeyRepository;

class KeyGambit implements GambitInterface
{
    protected $doorkeys;

    public function __construct(DoorkeyRepository $doorkeys)
    {
        $this->doorkeys = $doorkeys;
    }


    public function apply(SearchState $search, $searchValue)
    {
        $search->getQuery()->where('key', $searchValue);

        return true;
    }
}