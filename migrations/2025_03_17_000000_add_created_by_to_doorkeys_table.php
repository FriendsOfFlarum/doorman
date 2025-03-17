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
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
         });
     },
     'down' => function (Builder $schema) {
         $schema->table('doorkeys', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
         });
     },
 ];
