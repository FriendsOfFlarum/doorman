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

namespace FoF\Doorman\Api\Serializers;

use Flarum\Api\Serializer\AbstractSerializer;
use Flarum\Api\Serializer\GroupSerializer;
use Flarum\Api\Serializer\UserSerializer;
use FoF\Doorman\Doorkey;
use InvalidArgumentException;

class DoorkeySerializer extends AbstractSerializer
{
    /**
     * @var string
     */
    protected $type = 'doorkeys';

    /**
     * @param $doorkey
     *
     * @return array
     */
    protected function getDefaultAttributes($doorkey)
    {
        if (!($doorkey instanceof Doorkey)) {
            throw new InvalidArgumentException(
                get_class($this).' can only serialize instances of '.Doorkey::class
            );
        }

        return [
            'key'       => $doorkey->key,
            'uses'      => (int) $doorkey->uses,
            'groupId'   => (int) $doorkey->group_id, // 🤯
            'maxUses'   => (int) $doorkey->max_uses,
            'activates' => (bool) $doorkey->activates,
        ];
    }

    protected function group($user)
    {
        return $this->hasOne($user, GroupSerializer::class);
    }

    protected function createdBy($user)
    {
        return $this->hasOne($user, UserSerializer::class);
    }
}
