<?php

/**
 *  This file is part of reflar/doorman.
 *
 *  Copyright (c) 2018 .
 *
 *
 *  For the full copyright and license information, please view the LICENSE.md
 *  file that was distributed with this source code.
 */

namespace Reflar\Doorman;

use Flarum\Database\AbstractModel;
use Flarum\Group\Group;

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
