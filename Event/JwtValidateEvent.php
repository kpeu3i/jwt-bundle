<?php

namespace Kpeu3i\JwtBundle\Event;

use Kpeu3i\JwtBundle\Jwt\Claim\ClaimCollectionInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class JwtValidateEvent
 *
 * @package Kpeu3i\JwtBundle\Event
 */
class JwtValidateEvent extends Event
{
    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @var
     */
    protected $jwt;

    /**
     * @var ClaimCollectionInterface
     */
    protected $claims;

    /**
     * @param UserInterface $user
     * @param $jwt
     * @param ClaimCollectionInterface $claims
     */
    public function __construct(UserInterface $user, $jwt, ClaimCollectionInterface $claims)
    {
        $this->user = $user;
        $this->jwt = $jwt;
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
     * @return mixed
     */
    public function getJwt()
    {
        return $this->jwt;
    }

    /**
     * @return ClaimCollectionInterface
     */
    public function getClaims()
    {
        return $this->claims;
    }
}
