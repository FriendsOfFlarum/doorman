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

use Flarum\Database\Migration;

return Migration::addColumns('doorkeys', [
    'created_by' => ['integer', 'unsigned' => true, 'nullable' => true],
]);
