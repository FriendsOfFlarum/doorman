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

namespace FoF\Doorman\Tests\integration;

use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\Testing\integration\RetrievesAuthorizedUsers;
use Flarum\Testing\integration\TestCase;
use Flarum\User\Event\RegisteringFromProvider;
use Flarum\User\User;
use FoF\Doorman\DoorkeyBypassRegistry;
use FoF\Doorman\Extend\BypassDoorkey;
use FoF\Doorman\Listeners\OAuthBypassDoorkey;
use FoF\Doorman\Listeners\ValidateDoorkey;
use FoF\Doorman\Validators\DoorkeyLoginValidator;

class OAuthBypassTest extends TestCase
{
    use RetrievesAuthorizedUsers;

    protected function setUp(): void
    {
        parent::setUp();

        // Enable doorkey requirement
        $this->setting('fof-doorman.allowPublic', 'false');

        $this->extension('fof-oauth');
        $this->extension('fof-doorman');

        // Set up the database with some test data
        $this->prepareDatabase([
            'doorkeys' => [
                ['id' => 1, 'key' => 'TESTKEY1', 'group_id' => 3, 'max_uses' => 10, 'uses' => 0, 'activates' => 1],
            ],
            'users' => [
                $this->normalUser(),
            ],
        ]);
    }

    /**
     * Test that the BypassDoorkey extender correctly registers providers.
     */
    public function test_bypass_doorkey_extender_registers_providers(): void
    {
        // Apply the extender BEFORE booting the app
        $this->extend((new BypassDoorkey())
            ->forProvider('github')
            ->forProvider('discord'));

        // Now boot the app
        $app = $this->app();

        // Get the registry from the container
        $registry = $app->getContainer()->make(DoorkeyBypassRegistry::class);

        // Verify that the providers were registered
        $this->assertTrue($registry->isProviderAllowed('github'), 'GitHub provider should be allowed');
        $this->assertTrue($registry->isProviderAllowed('discord'), 'Discord provider should be allowed');
        $this->assertFalse($registry->isProviderAllowed('gitlab'), 'GitLab provider should not be allowed');
    }

    /**
     * Test that the OAuthBypassDoorkey listener correctly marks users as exempt.
     */
    public function test_oauth_bypass_doorkey_listener_marks_users_exempt(): void
    {
        // Boot the app
        $app = $this->app();

        // Get the registry from the container
        $registry = $app->getContainer()->make(DoorkeyBypassRegistry::class);

        // Register a provider directly in the registry
        $registry->registerProvider('github');

        // Create a mock user
        $user = new User();

        // Create the event
        $event = new RegisteringFromProvider($user, 'github', []);

        // Create the listener with the registry
        $listener = new OAuthBypassDoorkey($registry);

        // Handle the event
        $listener->handle($event);

        // Verify that the user was marked as exempt
        $this->assertTrue(isset($user->doorkey_identifier));
        $this->assertTrue($registry->isUserExempt($user->doorkey_identifier));

        // Test with a non-allowed provider
        $user2 = new User();
        $event2 = new RegisteringFromProvider($user2, 'gitlab', []);
        $listener->handle($event2);

        // Verify that the user was not marked as exempt
        $this->assertFalse(isset($user2->doorkey_identifier));
    }

    /**
     * Test that the doorkey_identifier property is removed before saving.
     */
    public function test_doorkey_identifier_is_removed_before_saving(): void
    {
        // Boot the app
        $app = $this->app();

        // Get the registry from the container
        $registry = $app->getContainer()->make(DoorkeyBypassRegistry::class);

        // Register a provider
        $registry->registerProvider('github');

        // Create a user that's exempt (simulating OAuth registration)
        $user = new User();
        $identifier = spl_object_hash($user);
        $registry->exemptUser($identifier);
        $user->doorkey_identifier = $identifier;

        // Create a mock event
        $data = [
            'attributes' => [
                'username' => 'test_user_'.rand(1000, 9999),
                'email'    => 'test'.rand(1000, 9999).'@example.com',
                'password' => 'password123',
            ],
        ];

        $event = new \Flarum\User\Event\Saving($user, new User(), $data);

        // Create the validator listener
        $validator = $app->getContainer()->make(DoorkeyLoginValidator::class);
        $settings = $app->getContainer()->make(SettingsRepositoryInterface::class);
        $validateListener = new ValidateDoorkey($validator, $settings, $registry);

        // Handle the event
        $validateListener->handle($event);

        // Verify that the doorkey_identifier property was removed
        $this->assertFalse(isset($user->doorkey_identifier));
    }
}
