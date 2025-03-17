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

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        $schema->table('doorkeys', function (Blueprint $table) {
            $table->fullText('key');
        });
    },

    'down' => function (Builder $schema) {
        $schema->table('doorkeys', function (Blueprint $table) {
            $table->dropFullText('key');
        });
    },
];
