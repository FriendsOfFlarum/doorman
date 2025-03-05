<?php

namespace FoF\Doorman\Repository;

use Illuminate\Database\Eloquent\Builder;
use FoF\Doorman\Doorkey;
use Flarum\User\User;

class DoorkeyRepository
{
    public function query()
    {
        return Doorkey::query();
    }

    public function findOrFail($id, User $actor = null)
    {
        $query = $this->query()->where('id', $id);

        return $this->scopeVisibleTo($query, $actor)->firstOrFail();
    }

    protected function scopeVisibleTo(Builder $query, User $actor = null)
    {
        if ($actor !== null) {
            $query->whereVisibleTo($actor);
        }

        return $query;
    }
}