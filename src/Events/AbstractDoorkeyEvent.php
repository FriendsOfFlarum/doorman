<?php

namespace FoF\Doorman\Events;

use Flarum\User\User;
use FoF\Doorman\Doorkey;

abstract class AbstractDoorkeyEvent
{
    /**
     * @var Doorkey
     */
    protected $doorkey;

    /**
     * @var User
     */
    protected $actor;


    /**
     * @var array
     */
    public array $data;

    public function __construct(Doorkey $doorkey, User $actor, array $data)
    {
        $this->doorkey = $doorkey;
        $this->actor = $actor;
        $this->data = $data;
    }
}
