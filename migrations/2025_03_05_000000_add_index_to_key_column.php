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

// Fulltext indexes are only supported by MySQL/MariaDB; `fullText()` throws on
// other drivers (e.g. SQLite, PostgreSQL). The guard keeps this historical
// migration runnable everywhere. The fulltext index is later dropped in favour
// of a portable B-tree index — see 2026_06_02_000000_replace_key_fulltext_with_index.
$supportsFullText = fn (Builder $schema): bool => in_array(
    $schema->getConnection()->getDriverName(),
    ['mysql', 'mariadb'],
    true
);

return [
    'up' => function (Builder $schema) use ($supportsFullText) {
        if (!$supportsFullText($schema)) {
            return;
        }

        $schema->table('doorkeys', function (Blueprint $table) {
            $table->fullText('key');
        });
    },

    'down' => function (Builder $schema) use ($supportsFullText) {
        if (!$supportsFullText($schema)) {
            return;
        }

        $schema->table('doorkeys', function (Blueprint $table) {
            $table->dropFullText(['key']);
        });
    },
];
