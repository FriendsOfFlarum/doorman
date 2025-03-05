<?php

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