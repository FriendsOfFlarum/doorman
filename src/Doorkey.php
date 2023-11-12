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
use Flarum\Group\Group;

/**
 * @property string $key
 * @property int $group_id
 * @property int $max_uses
 * @property int $activates
 * @property int $uses
 */
class Doorkey extends AbstractModel
{
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
}
