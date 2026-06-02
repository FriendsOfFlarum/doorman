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

namespace FoF\Doorman\Repository;

use FoF\Doorman\Doorkey;
use Illuminate\Database\Eloquent\Builder;

class DoorkeyRepository
{
    /**
     * @return Builder<Doorkey>
     */
    public function query(): Builder
    {
        return Doorkey::query();
    }

    public function getByKey(?string $key): ?Doorkey
    {
        if ($key === null) {
            return null;
        }

        $normalized = strtoupper(trim($key));

        if ($normalized === '') {
            return null;
        }

        return $this->query()->where('key', $normalized)->first();
    }
}
