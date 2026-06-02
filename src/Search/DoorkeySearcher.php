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

use FoF\Doorman\Doorkey;
use Flarum\Search\Database\AbstractSearcher;
use Flarum\User\User;
use Illuminate\Database\Eloquent\Builder;

class DoorkeySearcher extends AbstractSearcher
{
    public function getQuery(User $actor): Builder
    {
        return Doorkey::query()->whereVisibleTo($actor);
    }
}
