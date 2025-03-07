<?php

namespace FoF\Doorman\Content;

use Flarum\Frontend\Document;
use Psr\Http\Message\ServerRequestInterface as Request;
use FoF\Doorman\Doorkey;

class AdminPayload
{
    public function __invoke(Document $document, Request $request)
    {
        $document->payload['modelStatistics'] = $document->payload['modelStatistics'] ?? [];

        $document->payload['modelStatistics']['doorkeys'] = [
            'total' => Doorkey::count()
        ];
    }
}