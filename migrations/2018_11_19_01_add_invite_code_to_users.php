<?php

use Flarum\Database\Migration;

return Migration::addColumns('users', [
    'invite_code' => ['string', 'length' => 128, 'nullable' => true],
]);
