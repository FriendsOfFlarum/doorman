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

// The `key` column was given a fulltext index (2025_03_05) intended to power
// search. That was the wrong tool: the admin search uses a leading-wildcard
// LIKE which no index can accelerate, and fulltext indexes only exist on
// MySQL/MariaDB. The query that actually benefits from an index is the
// exact-match lookup in DoorkeyRepository::getByKey(), which a portable B-tree
// index serves on every driver. This migration swaps one for the other.
//
// Index names are Laravel's deterministic "{table}_{column}_{type}" form.
$fulltextIndex = 'doorkeys_key_fulltext';
$btreeIndex = 'doorkeys_key_index';

$supportsFullText = fn (Builder $schema): bool => in_array(
    $schema->getConnection()->getDriverName(),
    ['mysql', 'mariadb'],
    true
);

return [
    'up' => function (Builder $schema) use ($supportsFullText, $fulltextIndex, $btreeIndex) {
        // Drop the now-unused fulltext index where it was created.
        if ($supportsFullText($schema) && $schema->hasIndex('doorkeys', $fulltextIndex)) {
            $schema->table('doorkeys', function (Blueprint $table) {
                $table->dropFullText(['key']);
            });
        }

        // Add the portable B-tree index used by exact-match key lookups.
        if (!$schema->hasIndex('doorkeys', $btreeIndex)) {
            $schema->table('doorkeys', function (Blueprint $table) {
                $table->index('key');
            });
        }
    },

    'down' => function (Builder $schema) use ($supportsFullText, $fulltextIndex, $btreeIndex) {
        if ($schema->hasIndex('doorkeys', $btreeIndex)) {
            $schema->table('doorkeys', function (Blueprint $table) {
                $table->dropIndex(['key']);
            });
        }

        if ($supportsFullText($schema) && !$schema->hasIndex('doorkeys', $fulltextIndex)) {
            $schema->table('doorkeys', function (Blueprint $table) {
                $table->fullText('key');
            });
        }
    },
];
