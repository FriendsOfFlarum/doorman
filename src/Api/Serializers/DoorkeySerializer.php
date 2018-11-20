<?php

/**
 *  This file is part of reflar/doorman.
 *
 *  Copyright (c) 2018 ReFlar.
 *
 *  https://reflar.redevs.org
 *
 *  For the full copyright and license information, please view the LICENSE.md
 *  file that was distributed with this source code.
 */

namespace Reflar\Doorman\Api\Serializers;

use Flarum\Api\Serializer\AbstractSerializer;
use Reflar\Doorman\Doorkey;

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
            'uses'      => $doorkey->uses,
            'groupId'   => $doorkey->group_id, // 🤯
            'maxUses'   => $doorkey->max_uses,
            'activates' => $doorkey->activates,
        ];
    }
}
