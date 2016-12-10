<?php

namespace Kpeu3i\JwtBundle\Event;

use Kpeu3i\JwtBundle\Security\Authentication\Token\JwtToken;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class AuthenticationSuccessEvent
 *
 * @package Kpeu3i\JwtBundle\Event
 */
class AuthenticationSuccessEvent extends Event
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * @var JwtToken
     */
    protected $token;

    /**
     * @param Request $request
     * @param Response $response
     * @param JwtToken $token
     */
    public function __construct(Request $request, Response $response, JwtToken $token)
    {
        $this->request = $request;
        $this->response = $response;
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
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param Response $response
     */
    public function setResponse(Response $response)
    {
        $this->response = $response;
    }

    /**
     * @return JwtToken
     */
    public function getToken()
    {
        return $this->token;
    }
}
