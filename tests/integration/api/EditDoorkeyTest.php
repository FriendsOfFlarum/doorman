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

class EditDoorkeyTest extends TestCase
{
    use RetrievesAuthorizedUsers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->extension('fof-doorman');

        $this->prepareDatabase([
            'doorkeys' => [
                ['id' => 1, 'key' => 'ORIGINALKEY', 'group_id' => 3, 'max_uses' => 10, 'uses' => 0, 'activates' => 1],
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
    public function permitted_users_can_edit_doorkey($actorId)
    {
        $response = $this->send(
            $this->request('PATCH', '/api/fof/doorkeys/1', [
                'authenticatedAs' => $actorId,
                'json' => [
                    'data' => [
                        'attributes' => [
                            'activates' => false,
                            'groupId' => 3,
                            'key' => 'EDITEDKEY',
                            'maxUses' => 15,
                            'uses' => 0,
                        ],
                        'type' => 'doorkeys',
                    ],
                ],
            ]),
        );

        $this->assertEquals(200, $response->getStatusCode());

        $response = json_decode($response->getBody()->getContents(), true);

        $this->assertEquals(false, Arr::get($response, 'data.attributes.activates'));
        $this->assertEquals(15, Arr::get($response, 'data.attributes.maxUses'));

        $doorkey = Doorkey::find(1);
        $this->assertEquals(false, $doorkey->activates);
        $this->assertEquals(15, $doorkey->max_uses);

    }

    /**
     * @test
     *
     * @dataProvider unpermittedUsers
     */
    public function unpermitted_users_cannot_edit_doorkey($actorId)
    {
        $response = $this->send(
            $this->request('PATCH', '/api/fof/doorkeys/1', [
                'authenticatedAs' => $actorId,
                'json' => [
                    'data' => [
                        'attributes' => [
                            'activates' => false,
                            'groupId' => 3,
                            'key' => 'EDITEDKEY',
                            'maxUses' => 15,
                            'uses' => 0,
                        ],
                    ],
                ],
            ]),
        );

        $this->assertEquals(403, $response->getStatusCode());

        $doorkey = Doorkey::find(1);
        $this->assertEquals('ORIGINALKEY', $doorkey->key);
        $this->assertEquals(10, $doorkey->max_uses);
    }
}