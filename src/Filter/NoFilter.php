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

class NoFilter implements FilterInterface
{
    public function getFilterKey(): string
    {
        return 'noDoormanFilter';
    }

    public function filter(FilterState $filterState, string $filterValue, bool $negate)
    {
        // Does nothing
    }
}
