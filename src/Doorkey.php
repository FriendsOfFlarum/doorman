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

    public static function build($key, $groupId, $maxUses, $activates)
    {
        $doorkey = new static();
        $doorkey->key = strtoupper($key);
        $doorkey->group_id = $groupId;
        $doorkey->max_uses = $maxUses;
        $doorkey->activates = $activates;

        return $doorkey;
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
