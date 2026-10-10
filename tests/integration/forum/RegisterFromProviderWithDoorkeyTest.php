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

use Carbon\Carbon;
use Flarum\Extend;
use Flarum\Testing\integration\TestCase;
use Flarum\User\User;
use FoF\Doorman\Doorkey;
use PHPUnit\Framework\Attributes\Test;

/**
 * fof/oauth can assign a group to users who sign up with a provider, and does so before doorman
 * handles `Registered`, so the doorkey's group may already be attached.
 */
class RegisterFromProviderWithDoorkeyTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->extend(
            (new Extend\Csrf())->exemptRoute('register')
        );

        $this->setting('fof-doorman.allowPublic', 'false');
        $this->setting('allow_sign_up', '1');
        $this->setting('mail_driver', 'log');
        $this->setting('fof-oauth.gitlab', '1');
        $this->setting('fof-oauth.gitlab.group', '4');

        $this->extension('fof-oauth');
        $this->extension('fof-doorman');

        $this->prepareDatabase([
            'doorkeys' => [
                ['id' => 1, 'key' => 'SAMEGROUP', 'group_id' => 4, 'max_uses' => 10, 'uses' => 0, 'activates' => 1],
                ['id' => 2, 'key' => 'OTHERGROUP', 'group_id' => 5, 'max_uses' => 10, 'uses' => 0, 'activates' => 1],
            ],
            'groups' => [
                ['id' => 5, 'name_singular' => 'Invitee', 'name_plural' => 'Invitees'],
            ],
            'registration_tokens' => [
                [
                    'token'           => 'gitlab-registration-token',
                    'provider'        => 'gitlab',
                    'identifier'      => '98765',
                    'user_attributes' => json_encode(['email' => 'provideruser@machine.local']),
                    'payload'         => json_encode([]),
                    'created_at'      => Carbon::now(),
                ],
            ],
        ]);
    }

    #[Test]
    public function provider_sign_up_succeeds_when_doorkey_and_provider_assign_the_same_group(): void
    {
        $response = $this->registerFromProvider('SAMEGROUP');

        $this->assertEquals(201, $response->getStatusCode(), (string) $response->getBody());

        $user = User::query()->where('username', 'provideruser')->firstOrFail();

        $this->assertEquals([4], $user->groups()->pluck('id')->all());
        $this->assertEquals(1, Doorkey::query()->find(1)->uses);
    }

    #[Test]
    public function provider_sign_up_gets_both_groups_when_they_differ(): void
    {
        $response = $this->registerFromProvider('OTHERGROUP');

        $this->assertEquals(201, $response->getStatusCode(), (string) $response->getBody());

        $user = User::query()->where('username', 'provideruser')->firstOrFail();

        $this->assertEqualsCanonicalizing([4, 5], $user->groups()->pluck('id')->all());
        $this->assertEquals(1, Doorkey::query()->find(2)->uses);
    }

    protected function registerFromProvider(string $doorkey): \Psr\Http\Message\ResponseInterface
    {
        return $this->send(
            $this->request('POST', '/register', [
                'json' => [
                    'username'    => 'provideruser',
                    'token'       => 'gitlab-registration-token',
                    'fof-doorkey' => $doorkey,
                ],
            ])
        );
    }
}
