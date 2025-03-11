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

namespace FoF\Doorman\Tests\integration\api;

use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use FoF\Doorman\Doorkey;

class DeleteDoorkeyTest extends TestCase
{
    use RetrievesAuthorizedUsers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->extension('fof-doorman');

        $this->prepareDatabase([
            'doorkeys' => [
                ['id' => 1, 'key' => 'DELETEME', 'group_id' => 3, 'max_uses' => 10, 'uses' => 0, 'activates' => 1],
            ],
            'users' => [
                $this->normalUser(),
            ],
        ]);
    }

    public function permittedUsers(): array
    {
        return [
            [1],
        ];
    }

    public function unpermittedUsers(): array
    {
        return [
            [2],
        ];
    }

    /**
     * @test
     *
     * @dataProvider permittedUsers
     */
    public function permitted_users_can_delete_doorkey($actorId)
    {
        $response = $this->send(
            $this->request('DELETE', '/api/fof/doorkeys/1', [
                'authenticatedAs' => $actorId,
            ])
        );

        $this->assertEquals(204, $response->getStatusCode());

        // Ensure the key was deleted
        $this->assertNull(Doorkey::find(1));
    }

    /**
     * @test
     *
     * @dataProvider unpermittedUsers
     */
    public function unpermitted_users_cannot_delete_doorkey($actorId)
    {
        $response = $this->send(
            $this->request('DELETE', '/api/fof/doorkeys/1', [
                'authenticatedAs' => $actorId,
            ])
        );

        $this->assertEquals(403, $response->getStatusCode());

        $this->assertNotNull(Doorkey::find(1));
    }
}
