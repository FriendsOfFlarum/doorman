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

class ListDoorkeysTestWithSearchTest extends TestCase
{
    use RetrievesAuthorizedUsers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->extension('fof-doorman');

        $this->database()->rollBack();

        $this->database()->table('doorkeys')->insert([
            ['id' => 1, 'key' => 'SecretKey', 'group_id' => 3, 'max_uses' => 10, 'uses' => 0, 'activates' => 1, 'created_by' => 1],
            ['id' => 2, 'key' => 'SecretKey2', 'group_id' => 3, 'max_uses' => 10, 'uses' => 1, 'activates' => 1, 'created_by' => 1],
            ['id' => 3, 'key' => '3Secret', 'group_id' => 3, 'max_uses' => 10, 'uses' => 2, 'activates' => 0, 'created_by' => 1],
            ['id' => 4, 'key' => 'ABCDEFG4', 'group_id' => 3, 'max_uses' => 10, 'uses' => 3, 'activates' => 1, 'created_by' => 1],
            ['id' => 5, 'key' => 'ABCDEFG5', 'group_id' => 3, 'max_uses' => 20, 'uses' => 4, 'activates' => 1, 'created_by' => 2],
            ['id' => 6, 'key' => 'ABCDEFG6', 'group_id' => 3, 'max_uses' => 10, 'uses' => 5, 'activates' => 1, 'created_by' => 2],
        ]);

        $this->database()->table('users')->insert([
            $this->normalUser(),
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
                 'filter' => ['q' => 'ABCDEFG6'],
             ])
        );

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody()->getContents(), true);
        $ids = array_map(function ($row) {
            return $row['id'];
        }, $data['data']);

        $this->assertEqualsCanonicalizing(['6'], $ids, 'ID does not match');
    }

    /**
     * @test
     */
    public function admin_can_search_for_partial_key()
    {
        $response = $this->send(
            $this->request('GET', '/api/fof/doorkeys', [
                'authenticatedAs' => 1,
            ])
             ->withQueryParams([
                 'filter' => ['q' => 'Secret'],
             ])
        );

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody()->getContents(), true);
        $ids = array_map(function ($row) {
            return $row['id'];
        }, $data['data']);

        $this->assertEqualsCanonicalizing(['1', '2', '3'], $ids, 'IDs do not match');
    }

    /**
     * @test
     */
    public function admin_can_search_using_created_by_gambit()
    {
        $response = $this->send(
            $this->request('GET', '/api/fof/doorkeys', [
                'authenticatedAs' => 1,
            ])
             ->withQueryParams([
                 'filter' => ['q' => 'created_by:normal'],
             ])
        );

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody()->getContents(), true);
        $ids = array_map(function ($row) {
            return $row['id'];
        }, $data['data']);

        $this->assertEqualsCanonicalizing(['5', '6'], $ids, 'IDs do not match');
    }

    /**
     * @test
     */
    public function admin_can_search_using_created_by_gambit_with_negate()
    {
        $response = $this->send(
            $this->request('GET', '/api/fof/doorkeys', [
                'authenticatedAs' => 1,
            ])
             ->withQueryParams([
                 'filter' => ['q' => '-created_by:normal'],
             ])
        );

        $this->assertEquals(200, $response->getStatusCode());

        $data = json_decode($response->getBody()->getContents(), true);
        $ids = array_map(function ($row) {
            return $row['id'];
        }, $data['data']);

        $this->assertEqualsCanonicalizing(['1', '2', '3', '4'], $ids, 'IDs do not match');
    }
}
