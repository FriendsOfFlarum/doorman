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

namespace FoF\Doorman\Filter;

use Flarum\Filter\FilterInterface;
use Flarum\Filter\FilterState;
use Flarum\Filter\ValidateFilterTrait;
use Flarum\Search\AbstractRegexGambit;
use Flarum\Search\SearchState;
use Flarum\User\UserRepository;
use Illuminate\Database\Query\Builder;

class CreatedByFilterGambit extends AbstractRegexGambit implements FilterInterface
{
    use ValidateFilterTrait;

    /**
     * @var \Flarum\User\UserRepository
     */
    protected $users;

    /**
     * @param \Flarum\User\UserRepository $users
     */
    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    /**
     * {@inheritdoc}
     */
    public function getGambitPattern()
    {
        return 'created_by:(.+)';
    }

    /**
     * {@inheritdoc}
     */
    protected function conditions(SearchState $search, array $matches, $negate)
    {
        $this->constrain($search->getQuery(), $matches[1], $negate);
    }

    public function getFilterKey(): string
    {
        return 'created_by';
    }

    public function filter(FilterState $filterState, $filterValue, bool $negate)
    {
        $this->constrain($filterState->getQuery(), $filterValue, $negate);
    }

    protected function constrain(Builder $query, $rawUsernames, $negate)
    {
        $usernames = $this->asStringArray($rawUsernames);

        $ids = $this->users->getIdsForUsernames($usernames);

        $query->whereIn('doorkeys.created_by', $ids, 'and', $negate);
    }
}
