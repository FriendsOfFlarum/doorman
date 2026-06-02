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
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

class SendInvitesTest extends TestCase
{
    use RetrievesAuthorizedUsers;

    protected function setUp(): void
    {
        parent::setUp();

        // The log driver renders the templated email (exercising the views)
        // without performing any network I/O.
        $this->setting('mail_driver', 'log');

        $this->extension('fof-doorman');

        $this->prepareDatabase([
            'doorkeys' => [
                ['id' => 1, 'key' => 'TESTKEY1', 'group_id' => 4, 'max_uses' => 10, 'uses' => 0, 'activates' => 1],
            ],
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
    public function admins_can_send_invites($actorId)
    {
        $response = $this->send(
            $this->request('POST', '/api/doorkeys/invites', [
                'authenticatedAs' => $actorId,
                'json'            => [
                    'doorkeyId' => 1,
                    'emails'    => ['invitee1@machine.local', 'invitee2@machine.local'],
                ],
            ])
        );

        $this->assertEquals(204, $response->getStatusCode(), (string) $response->getBody());
    }

    #[Test]
    #[DataProvider('unpermittedUsers')]
    public function non_admins_cannot_send_invites($actorId)
    {
        $response = $this->send(
            $this->request('POST', '/api/doorkeys/invites', [
                'authenticatedAs' => $actorId,
                'json'            => [
                    'doorkeyId' => 1,
                    'emails'    => ['invitee@machine.local'],
                ],
            ])
        );

        $this->assertEquals(403, $response->getStatusCode());
    }
}
