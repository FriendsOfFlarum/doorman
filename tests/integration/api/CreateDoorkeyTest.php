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
use Illuminate\Support\Arr;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

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

    public static function permittedUsers(): array
    {
        return [
            [1],
        ];
    }

    public static function unpermittedUsers(): array
    {
        return [
            [2],
        ];
    }

    #[Test]
    #[DataProvider('permittedUsers')]
    public function permitted_users_can_create_doorkey($actorId)
    {
        $response = $this->send(
            $this->request('POST', '/api/doorkeys', [
                'authenticatedAs' => $actorId,
                'json'            => [
                    'data' => [
                        'attributes' => [
                            'activates' => true,
                            'groupId'   => 3,
                            'key'       => 'ABCDEFG1',
                            'maxUses'   => 10,
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
        $this->assertEquals($actorId, Doorkey::first()->created_by);
    }

    #[Test]
    #[DataProvider('unpermittedUsers')]
    public function unpermitted_users_cannot_create_doorkey($actorId)
    {
        $response = $this->send(
            $this->request('POST', '/api/doorkeys', [
                'authenticatedAs' => $actorId,
                'json'            => [
                    'data' => [
                        'attributes' => [
                            'activates' => true,
                            'groupId'   => 3,
                            'key'       => 'ABCDEFG1',
                            'maxUses'   => 10,
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
