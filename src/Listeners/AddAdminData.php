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

namespace FoF\Doorman\Listeners;

use Flarum\Api\Controller\ShowForumController;
use FoF\Doorman\Doorkey;
use Psr\Http\Message\ServerRequestInterface;

class AddAdminData
{
    public function __invoke(ShowForumController $controller, &$data, ServerRequestInterface $request)
    {
        $data['doorkeys'] = [];
        if ($request->getAttribute('actor')->isAdmin()) {
            $data['doorkeys'] = Doorkey::all();
        }
    }
}
