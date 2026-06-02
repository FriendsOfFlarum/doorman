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

namespace FoF\Doorman\Search;

use Flarum\Search\Database\DatabaseSearchState;
use Flarum\Search\Filter\FilterInterface;
use Flarum\Search\SearchState;
use Flarum\Search\ValidateFilterTrait;
use Flarum\User\UserRepository;

/**
 * Filters doorkeys by the username(s) of the user who created them.
 *
 * @implements FilterInterface<DatabaseSearchState>
 */
class CreatedByFilter implements FilterInterface
{
    use ValidateFilterTrait;

    public function __construct(protected UserRepository $users)
    {
    }

    public function getFilterKey(): string
    {
        return 'created_by';
    }

    public function filter(SearchState $state, string|array $value, bool $negate): void
    {
        $usernames = $this->asStringArray($value);

        $ids = $this->users->getIdsForUsernames($usernames);

        $state->getQuery()->whereIn('doorkeys.created_by', $ids, 'and', $negate);
    }
}
