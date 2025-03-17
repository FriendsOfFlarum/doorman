<?php

use Flarum\Database\Migration;

return Migration::addColumns('doorkeys', [
    'created_by' => ['integer', 'unsigned' => true, 'nullable' => true],
]);
