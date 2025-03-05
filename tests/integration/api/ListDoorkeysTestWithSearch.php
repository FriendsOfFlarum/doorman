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

use Flarum\Testing\integration\TestCase;

class ListDoorkeysTestWithSearch extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->extension('fof-doorman');

        $this->database()->rollBack();

        $this->database()->table('doorkeys')->insert([
            ['id' => 1, 'key' => 'ABCDEFG1', 'group_id' => 3, 'max_uses' => 10, 'uses' => 0, 'activates' => 1],
            ['id' => 2, 'key' => 'ABCDEFG2', 'group_id' => 3, 'max_uses' => 10, 'uses' => 1, 'activates' => 1],
            ['id' => 3, 'key' => 'ABCDEFG3', 'group_id' => 3, 'max_uses' => 10, 'uses' => 2, 'activates' => 0],
            ['id' => 4, 'key' => 'ABCDEFG4', 'group_id' => 3, 'max_uses' => 10, 'uses' => 3, 'activates' => 1],
            ['id' => 5, 'key' => 'ABCDEFG5', 'group_id' => 3, 'max_uses' => 20, 'uses' => 4, 'activates' => 1],
            ['id' => 6, 'key' => 'ABCDEFG6', 'group_id' => 3, 'max_uses' => 10, 'uses' => 5, 'activates' => 1],
            ['id' => 7, 'key' => 'ABCDEFG7', 'group_id' => 3, 'max_uses' => 10, 'uses' => 6, 'activates' => 1],
            ['id' => 8, 'key' => 'ABCDEFG8', 'group_id' => 3, 'max_uses' => 30, 'uses' => 7, 'activates' => 1],
            ['id' => 9, 'key' => 'ABCDEFG9', 'group_id' => 3, 'max_uses' => 10, 'uses' => 8, 'activates' => 0],
            ['id' => 10, 'key' => 'ABCDEFG10', 'group_id' => 3, 'max_uses' => 10, 'uses' => 9, 'activates' => 1],
            ['id' => 11, 'key' => 'ABCDEFG11', 'group_id' => 3, 'max_uses' => 10, 'uses' => 10, 'activates' => 1],
            ['id' => 12, 'key' => 'ABCDEFG12', 'group_id' => 3, 'max_uses' => 10, 'uses' => 9, 'activates' => 0],
            ['id' => 13, 'key' => 'ABCDEFG13', 'group_id' => 3, 'max_uses' => 10, 'uses' => 8, 'activates' => 0],
            ['id' => 14, 'key' => 'ABCDEFG14', 'group_id' => 3, 'max_uses' => 10, 'uses' => 7, 'activates' => 1],
            ['id' => 15, 'key' => 'ABCDEFG15', 'group_id' => 3, 'max_uses' => 10, 'uses' => 6, 'activates' => 1],
            ['id' => 16, 'key' => 'ABCDEFG16', 'group_id' => 3, 'max_uses' => 10, 'uses' => 5, 'activates' => 0],
            ['id' => 17, 'key' => 'ABCDEFG17', 'group_id' => 3, 'max_uses' => 10, 'uses' => 4, 'activates' => 1],
            ['id' => 18, 'key' => 'ABCDEFG18', 'group_id' => 3, 'max_uses' => 10, 'uses' => 3, 'activates' => 1],
            ['id' => 19, 'key' => 'ABCDEFG19', 'group_id' => 3, 'max_uses' => 10, 'uses' => 2, 'activates' => 0],
            ['id' => 20, 'key' => 'ABCDEFG20', 'group_id' => 3, 'max_uses' => 40, 'uses' => 1, 'activates' => 1],
            ['id' => 21, 'key' => 'ABCDEFG21', 'group_id' => 3, 'max_uses' => 10, 'uses' => 0, 'activates' => 1],
            ['id' => 22, 'key' => 'ABCDEFG22', 'group_id' => 3, 'max_uses' => 10, 'uses' => 0, 'activates' => 0],
        ]);

        $this->database()->beginTransaction();

        $this->populateDatabase();
    }

    /**
     * @inheritDoc
     */
    protected function tearDown(): void
    {
        parent::tearDown();

        $this->database()->table('doorkeys')->delete();
    }

    /**
     * @test
     */
    public function admin_can_search_for_key()
    {
        $response = $this->send(
            $this->request('GET', '/api/fof/doorkeys', [
                'authenticatedAs' => 1,
            ])
             ->withQueryParams([
                 'filter' => ['q' => 'ABCDEFG22'],
             ])
        );

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody()->getContents(), true);
        $ids = array_map(function ($row) {
            return $row['id'];
        }, $data['data']);

        $this->assertEqualsCanonicalizing(['22'], $ids, 'ID does not match');
    }
}
