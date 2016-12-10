<?php

namespace Kpeu3i\JwtBundle\Event;

use Kpeu3i\JwtBundle\Jwt\Claim\ClaimCollectionInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class JwtCreateEvent
 *
 * @package Kpeu3i\JwtBundle\Event
 */
class JwtCreateEvent extends Event
{
    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @var ClaimCollectionInterface
     */
    protected $claims;

    /**
     * @param UserInterface $user
     * @param ClaimCollectionInterface $claims
     */
    public function __construct(UserInterface $user, ClaimCollectionInterface $claims)
    {
        $this->user = $user;
        $this->claims = $claims;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return ClaimCollectionInterface
     */
    public function getClaims()
    {
        return $this->claims;
    }

    /**
     * @param ClaimCollectionInterface $claims
     */
    public function setClaims(ClaimCollectionInterface $claims)
    {
        $this->claims = $claims;
    }
}
