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

use Flarum\User\User;
use FoF\Doorman\Doorkey;
use Illuminate\Database\Eloquent\Builder;

class DoorkeyRepository
{
    public function query()
    {
        return Doorkey::query();
    }

    public function findOrFail($id, ?User $actor = null)
    {
        $query = $this->query()->where('id', $id);

        return $this->scopeVisibleTo($query, $actor)->firstOrFail();
    }

    protected function scopeVisibleTo(Builder $query, ?User $actor = null)
    {
        if ($actor !== null) {
            $query->whereVisibleTo($actor);
        }

        return $query;
    }

    public function getByKey(?string $key): ?Doorkey
    {
        return $this->query()->where('key', $key)->first();
    }
}
