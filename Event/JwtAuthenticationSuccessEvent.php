<?php

namespace Kpeu3i\JwtBundle\Event;

use Kpeu3i\JwtBundle\Security\Authentication\Token\JwtToken;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class JwtAuthenticationSuccessEvent
 *
 * @package Kpeu3i\JwtBundle\Event
 */
class JwtAuthenticationSuccessEvent extends Event
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var JwtToken
     */
    protected $token;

    /**
     * @param Request $request
     * @param JwtToken $token
     */
    public function __construct(Request $request, JwtToken $token)
    {
        $this->request = $request;
        $this->token = $token;
    }

    /**
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @return JwtToken
     */
    public function getToken()
    {
        return $this->token;
    }
}
