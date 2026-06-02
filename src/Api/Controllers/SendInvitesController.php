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

namespace FoF\Doorman\Api\Controllers;

use Flarum\Api\Controller\AbstractCreateController;
use Flarum\Extension\ExtensionManager;
use Flarum\Http\RequestUtil;
use Flarum\Http\UrlGenerator;
use Flarum\Settings\SettingsRepositoryInterface;
use FoF\Doorman\Api\Serializers\DoorkeySerializer;
use FoF\Doorman\Doorkey;
use Illuminate\Contracts\Bus\Dispatcher;
use Illuminate\Contracts\Mail\Mailer;
use Illuminate\Mail\Message;
use Psr\Http\Message\ServerRequestInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Tobscure\JsonApi\Document;

/**
 * @TODO: Remove this in favor of one of the API resource classes that were added.
 *      Or extend an existing API Resource to add this to.
 *      Or use a vanilla RequestHandlerInterface controller.
 *      @link https://docs.flarum.org/2.x/extend/api#endpoints
 */
class SendInvitesController extends AbstractCreateController
{
    public $serializer = DoorkeySerializer::class;

    public function __construct(protected Dispatcher $bus, protected Mailer $mailer, protected TranslatorInterface $translator, protected UrlGenerator $url, protected SettingsRepositoryInterface $settings, protected ExtensionManager $extensions)
    {
    }

    /**
     * @param ServerRequestInterface $request
     * @param Document               $document
     *
     * @throws \Flarum\User\Exception\PermissionDeniedException
     *
     * @return mixed
     */
    protected function data(ServerRequestInterface $request, Document $document)
    {
        RequestUtil::getActor($request)->assertAdmin();

        $data = $request->getParsedBody();

        $doorkey = Doorkey::findOrFail($data['doorkeyId']);

        $title = $this->settings->get('forum_title');

        $subject = $this->settings->get('forum_title').' - '.$this->translator->trans('fof-doorman.email.subject');

        $body = $this->translator->trans('fof-doorman.email.body', [
            '{forum}' => $title,
            '{url}'   => $this->extensions->isEnabled('fof-direct-links') ? $this->url->to('forum')->route('direct-links-signup') : $this->url->to('forum')->base(),
            '{code}'  => $doorkey->key,
        ]);

        foreach ($data['emails'] as $email) {
            $this->mailer->raw(
                $body,
                function (Message $message) use ($subject, $email) {
                    $message->to($email)->subject($subject);
                }
            );
        }

        return $doorkey;
    }
}
