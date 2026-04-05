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

use Illuminate\Database\Schema\Builder;

return [
    'up' => function (Builder $schema) {
        $connection = $schema->getConnection();

        if ($schema->hasColumn('users', 'invite_code')) {
            $connection->table('users')
                ->whereNotNull('invite_code')
                ->orderBy('id')
                ->chunk(500, function ($rows) use ($connection) {
                    foreach ($rows as $row) {
                        $normalized = strtoupper(trim((string) $row->invite_code));
                        $stored = $normalized === '' ? null : $normalized;

                        if ($stored !== $row->invite_code) {
                            $connection->table('users')->where('id', $row->id)->update(['invite_code' => $stored]);
                        }
                    }
                });
        }

        if ($schema->hasTable('doorkeys') && $schema->hasColumn('doorkeys', 'key')) {
            $connection->table('doorkeys')
                ->orderBy('id')
                ->chunk(500, function ($rows) use ($connection) {
                    foreach ($rows as $row) {
                        $normalized = strtoupper(trim((string) $row->key));

                        if ($normalized === '') {
                            continue;
                        }

                        if ($normalized !== $row->key) {
                            $connection->table('doorkeys')->where('id', $row->id)->update(['key' => $normalized]);
                        }
                    }
                });
        }
    },

    'down' => function (Builder $schema) {
        // Irreversible: original spacing cannot be recovered.
    },
];
