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

namespace FoF\Doorman\Api\Resource;

use Flarum\Api\Context;
use Flarum\Api\Endpoint;
use Flarum\Api\Resource;
use Flarum\Api\Schema;
use Flarum\Api\Sort\SortColumn;
use Flarum\Extension\ExtensionManager;
use Flarum\Http\UrlGenerator;
use Flarum\Locale\TranslatorInterface;
use Flarum\Settings\SettingsRepositoryInterface;
use FoF\Doorman\Doorkey;
use FoF\Doorman\Events\DoorkeyCreated;
use FoF\Doorman\Events\DoorkeyDeleted;
use FoF\Doorman\Events\DoorkeyUpdated;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Mail\Message;
use Illuminate\Support\Arr;
use Laminas\Diactoros\Response\EmptyResponse;
use Tobyz\JsonApiServer\Context as OriginalContext;

/**
 * @extends Resource\AbstractDatabaseResource<Doorkey>
 */
class DoorkeyResource extends Resource\AbstractDatabaseResource
{
    public function __construct(
        protected Mailer $mailer,
        protected TranslatorInterface $translator,
        protected UrlGenerator $url,
        protected SettingsRepositoryInterface $settings,
        protected ExtensionManager $extensions,
    ) {
    }

    public function type(): string
    {
        return 'doorkeys';
    }

    public function model(): string
    {
        return Doorkey::class;
    }

    public function scope(Builder $query, OriginalContext $context): void
    {
        $query->whereVisibleTo($context->getActor());
    }

    public function endpoints(): array
    {
        return [
            Endpoint\Show::make()
                ->admin()
                ->defaultInclude(['group', 'createdBy']),
            Endpoint\Index::make()
                ->admin()
                ->defaultInclude(['group', 'createdBy'])
                ->paginate(),
            Endpoint\Create::make()
                ->admin(),
            Endpoint\Update::make()
                ->admin(),
            Endpoint\Delete::make()
                ->admin(),
            Endpoint\Endpoint::make('invites')
                ->route('POST', '/invites')
                ->admin()
                ->action(fn (Context $context) => $this->sendInvites($context))
                ->response(fn () => new EmptyResponse(204)),
        ];
    }

    public function fields(): array
    {
        return [
            Schema\Str::make('key')
                ->writable()
                ->requiredOnCreate()
                ->unique('doorkeys', 'key', true),

            // Maps to the `group_id` column.
            Schema\Integer::make('groupId')
                ->writable()
                ->requiredOnCreate()
                ->rule('exists:groups,id'),

            // Maps to the `max_uses` column.
            Schema\Integer::make('maxUses')
                ->writable()
                ->rule('min:0'),

            Schema\Boolean::make('activates')
                ->writable(),

            // Read-only counter, incremented when the key is redeemed.
            Schema\Integer::make('uses'),

            Schema\Relationship\ToOne::make('group')
                ->includable()
                ->type('groups'),

            // Maps to the `created_by` column.
            Schema\Relationship\ToOne::make('createdBy')
                ->includable()
                ->type('users'),
        ];
    }

    public function sorts(): array
    {
        return [
            SortColumn::make('key'),
            SortColumn::make('uses'),
            SortColumn::make('maxUses'),
        ];
    }

    /**
     * @param Doorkey $model
     */
    public function creating(object $model, OriginalContext $context): ?object
    {
        $model->created_by = $context->getActor()->id;

        // `uses` is a read-only counter that is not provided on create. The
        // column has no database-level default, so seed it explicitly to keep
        // inserts valid across all drivers (SQLite enforces NOT NULL strictly).
        $model->uses ??= 0;

        return $model;
    }

    /**
     * @param Doorkey $model
     */
    public function created(object $model, OriginalContext $context): ?object
    {
        $this->events->dispatch(
            new DoorkeyCreated($model, $context->getActor(), (array) Arr::get($context->body(), 'data', []))
        );

        return $model;
    }

    /**
     * @param Doorkey $model
     */
    public function updated(object $model, OriginalContext $context): ?object
    {
        $this->events->dispatch(
            new DoorkeyUpdated($model, $context->getActor(), (array) Arr::get($context->body(), 'data', []))
        );

        return $model;
    }

    /**
     * @param Doorkey $model
     */
    public function deleted(object $model, OriginalContext $context): void
    {
        $this->events->dispatch(
            new DoorkeyDeleted($model, $context->getActor(), [])
        );
    }

    /**
     * Email an invite containing a doorkey to a list of addresses.
     */
    protected function sendInvites(Context $context): void
    {
        $body = $context->body();

        /** @var Doorkey $doorkey */
        $doorkey = Doorkey::findOrFail(Arr::get($body, 'doorkeyId'));

        $title = $this->settings->get('forum_title');
        $subject = $title.' - '.$this->translator->trans('fof-doorman.email.subject');

        $message = $this->translator->trans('fof-doorman.email.body', [
            '{forum}' => $title,
            '{url}'   => $this->extensions->isEnabled('fof-direct-links')
                ? $this->url->to('forum')->route('direct-links-signup')
                : $this->url->to('forum')->base(),
            '{code}'  => $doorkey->key,
        ]);

        foreach ((array) Arr::get($body, 'emails', []) as $email) {
            $this->mailer->raw($message, function (Message $mail) use ($subject, $email) {
                $mail->to($email)->subject($subject);
            });
        }
    }
}
