<?php

namespace Kpeu3i\JwtBundle\Security\Authentication\Token;

use Kpeu3i\JwtBundle\Jwt\Claim\ClaimCollectionInterface;
use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class JwtToken
 *
 * @package Kpeu3i\JwtBundle\Security\Authentication\Token
 */
class JwtToken extends AbstractToken
{
    /**
     * @var ClaimCollectionInterface
     */
    protected $claims;

    /**
     * @var string
     */
    protected $jwt;

    /**
     * @param UserInterface $user
     * @param $jwt string
     * @param ClaimCollectionInterface $claims
     */
    public function __construct(UserInterface $user, $jwt, ClaimCollectionInterface $claims)
    {
        $this->setUser($user);

        parent::__construct($user->getRoles());

        $this->jwt = $jwt;
        $this->claims = $claims;

        parent::setAuthenticated(true);
    }

    /**
     * @return string
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

    /**
     * {@inheritdoc}
     */
    public function getCredentials()
    {
        return '';
    }
}
