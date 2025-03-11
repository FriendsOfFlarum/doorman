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
use Illuminate\Support\Arr;
use FoF\Doorman\Doorkey;

class CreateDoorkeyTest extends TestCase
{
    use RetrievesAuthorizedUsers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->extension('fof-doorman');

        $this->prepareDatabase([
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
    public function permitted_users_can_create_doorkey($actorId)
    {
        $response = $this->send(
            $this->request('POST', '/api/fof/doorkeys', [
                'authenticatedAs' => $actorId,
                'json' => [
                    'data' => [
                        'attributes' => [
                            'activates' => true,
                            'groupId' => 3,
                            'key' => 'ABCDEFG1',
                            'maxUses' => 10,
                            'uses' => 0,
                        ],
                        'type' => 'doorkeys',
                    ],
                ],
            ]),
        );

        $this->assertEquals(201, $response->getStatusCode());

        $response = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals('ABCDEFG1', Arr::get($response, 'data.attributes.key'));

        $this->assertEquals(1, Doorkey::count());

    }

    /**
     * @test
     *
     * @dataProvider unpermittedUsers
     */
    public function unpermitted_users_cannot_create_doorkey($actorId)
    {
        $response = $this->send(
            $this->request('POST', '/api/fof/doorkeys', [
                'authenticatedAs' => $actorId,
                'json' => [
                    'data' => [
                        'attributes' => [
                            'activates' => true,
                            'groupId' => 3,
                            'key' => 'ABCDEFG1',
                            'maxUses' => 10,
                            'uses' => 0,
                        ],
                    ],
                ],
            ]),
        );

        $this->assertEquals(403, $response->getStatusCode());

        $response = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(0, Doorkey::count());
    }
}