<?php

namespace Kpeu3i\JwtBundle\Event;

use Kpeu3i\JwtBundle\Security\Authentication\Token\JwtToken;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;

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
