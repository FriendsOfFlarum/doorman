<?php

/*
 * This file is part of fof/doorman.
 *
 * Copyright (c) 2018-2020 Reflar.
 * Copyright (c) 2020 FriendsOfFlarum
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 *
 */

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        if (!$schema->hasTable('doorkeys')) {
            $schema->create('doorkeys', function (Blueprint $table) {
                $table->increments('id');
                $table->string('key');
                $table->integer('group_id')->unsigned()->nullable();
                $table->integer('max_uses')->unsigned();
                $table->integer('uses')->unsigned();
                $table->boolean('activates');

                $table->foreign('group_id')->references('id')->on('groups');
            });
        }
    },
    'down' => function (Builder $schema) {
        $schema->drop('doorkeys');
    },
];
