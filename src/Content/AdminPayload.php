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

namespace FoF\Doorman\Content;

use Flarum\Frontend\Document;
use FoF\Doorman\Doorkey;
use Psr\Http\Message\ServerRequestInterface as Request;

class AdminPayload
{
    public function __invoke(Document $document, Request $request)
    {
        $document->payload['modelStatistics'] = $document->payload['modelStatistics'] ?? [];

        $document->payload['modelStatistics']['doorkeys'] = [
            'total' => Doorkey::count(),
        ];
    }
}
