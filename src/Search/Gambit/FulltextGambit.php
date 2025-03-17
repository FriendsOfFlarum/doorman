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

namespace FoF\Doorman\Search\Gambit;

use Flarum\Search\GambitInterface;
use Flarum\Search\SearchState;
use FoF\Doorman\Repository\DoorkeyRepository;

class FulltextGambit implements GambitInterface
{
    protected $doorkeys;

    public function __construct(DoorkeyRepository $doorkeys)
    {
        $this->doorkeys = $doorkeys;
    }

    public function apply(SearchState $search, $searchValue)
    {
        $search->getQuery()
            ->whereIn(
                'id',
                $this->getUserSearchSubQuery($searchValue)
            );

        return true;
    }

    private function getUserSearchSubQuery($searchValue)
    {
        return $this->doorkeys
            ->query()
            ->select('id')
            ->where('key', 'like', "%{$searchValue}%");
    }
}
