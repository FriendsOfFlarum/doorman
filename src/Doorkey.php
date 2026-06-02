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

namespace FoF\Doorman;

use Flarum\Database\AbstractModel;
use Flarum\Database\ScopeVisibilityTrait;
use Flarum\Group\Group;
use Flarum\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property string $key
 * @property int    $group_id
 * @property int    $max_uses
 * @property int    $activates
 * @property int    $uses
 * @property int    $created_by
 */
class Doorkey extends AbstractModel
{
    use ScopeVisibilityTrait;

    /**
     * @var string
     */
    protected $table = 'doorkeys';

    /**
     * Normalize the key attribute on write: trim whitespace and uppercase.
     *
     * @param string|null $value
     */
    public function setKeyAttribute($value): void
    {
        $this->attributes['key'] = strtoupper(trim((string) $value));
    }

    /**
     * @return BelongsTo<Group, $this>
     */
    public function group(): BelongsTo
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
