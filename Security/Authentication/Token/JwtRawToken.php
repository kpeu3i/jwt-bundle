<?php

namespace Kpeu3i\JwtBundle\Security\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

/**
 * Class JwtRawToken
 *
 * @package Kpeu3i\JwtBundle\Security\Authentication\Token
 */
class JwtRawToken extends AbstractToken
{
    /**
     * @var string
     */
    protected $jwt;

    /**
     * @param string $jwt
     */
    public function __construct($jwt)
    {
        parent::__construct();

        $this->jwt = $jwt;
    }

    /**
     * @return string
     */
    public function getJwt()
    {
        return $this->jwt;
    }

    /**
     * {@inheritdoc}
     */
    public function setAuthenticated($authenticated)
    {
        throw new \LogicException('You cannot set this token to authenticated');
    }

    /**
     * {@inheritdoc}
     */
    public function setUser($user)
    {
        throw new \LogicException('You cannot set user to this token');
    }

    /**
     * {@inheritdoc}
     */
    public function getCredentials()
    {
        return '';
    }
}
