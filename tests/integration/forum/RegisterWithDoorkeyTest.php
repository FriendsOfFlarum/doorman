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

namespace FoF\Doorman\Tests\integration\forum;

use Flarum\Extend;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use Flarum\User\User;
use FoF\Doorman\Doorkey;
use PHPUnit\Framework\Attributes\Test;

class RegisterWithDoorkeyTest extends TestCase
{
    use RetrievesAuthorizedUsers;

    protected function setUp(): void
    {
        parent::setUp();

        $this->extend(
            (new Extend\Csrf())->exemptRoute('register')
        );

        // Require a doorkey to register.
        $this->setting('fof-doorman.allowPublic', 'false');
        $this->setting('allow_sign_up', '1');
        $this->setting('mail_driver', 'log');

        $this->extension('fof-doorman');

        $this->prepareDatabase([
            'doorkeys' => [
                // group_id 4 (Mods): PostRegisterOperations skips the default
                // Members group (3), so a non-default group lets us assert the
                // group was actually attached.
                ['id' => 1, 'key' => 'TESTKEY1', 'group_id' => 4, 'max_uses' => 10, 'uses' => 0, 'activates' => 1],
            ],
        ]);
    }

    #[Test]
    public function guest_can_register_with_a_valid_doorkey()
    {
        $response = $this->send(
            $this->request('POST', '/register', [
                'json' => [
                    'username'    => 'doorkeyuser',
                    'email'       => 'doorkeyuser@machine.local',
                    'password'    => 'too-obscure',
                    'fof-doorkey' => 'TESTKEY1',
                ],
            ])
        );

        $this->assertEquals(201, $response->getStatusCode(), (string) $response->getBody());

        $user = User::where('username', 'doorkeyuser')->firstOrFail();

        // The doorkey was consumed and recorded against the user.
        $this->assertEquals('TESTKEY1', $user->invite_code);

        // The user was added to the doorkey's group.
        $this->assertTrue($user->groups->pluck('id')->contains(4), 'User should be added to the doorkey group');

        // The doorkey's usage counter was incremented.
        $this->assertEquals(1, Doorkey::find(1)->uses, 'Doorkey usage should be incremented');
    }

    #[Test]
    public function guest_cannot_register_with_an_invalid_doorkey()
    {
        $response = $this->send(
            $this->request('POST', '/register', [
                'json' => [
                    'username'    => 'baduser',
                    'email'       => 'baduser@machine.local',
                    'password'    => 'too-obscure',
                    'fof-doorkey' => 'WRONGKEY',
                ],
            ])
        );

        $this->assertEquals(422, $response->getStatusCode());
        $this->assertNull(User::where('username', 'baduser')->first());
        $this->assertEquals(0, Doorkey::find(1)->uses);
    }

    #[Test]
    public function guest_cannot_register_without_a_doorkey_when_required()
    {
        $response = $this->send(
            $this->request('POST', '/register', [
                'json' => [
                    'username' => 'nokeyuser',
                    'email'    => 'nokeyuser@machine.local',
                    'password' => 'too-obscure',
                ],
            ])
        );

        $this->assertEquals(422, $response->getStatusCode());
        $this->assertNull(User::where('username', 'nokeyuser')->first());
    }

    #[Test]
    public function guest_can_register_without_a_doorkey_when_optional()
    {
        // When public registration is allowed, the doorkey becomes optional.
        $this->setting('fof-doorman.allowPublic', 'true');

        $response = $this->send(
            $this->request('POST', '/register', [
                'json' => [
                    'username' => 'publicuser',
                    'email'    => 'publicuser@machine.local',
                    'password' => 'too-obscure',
                ],
            ])
        );

        $this->assertEquals(201, $response->getStatusCode(), (string) $response->getBody());

        $user = User::where('username', 'publicuser')->firstOrFail();

        // No doorkey was supplied, so none was recorded or consumed.
        $this->assertEmpty($user->invite_code);
        $this->assertEquals(0, Doorkey::find(1)->uses);
    }
}
