<?php

namespace Kpeu3i\JwtBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * Class AuthenticationFailureEvent
 *
 * @package Kpeu3i\JwtBundle\Event
 */
class AuthenticationFailureEvent extends Event
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
     * @var AuthenticationException
     */
    protected $authenticationException;

    /**
     * @param Request $request
     * @param Response $response
     * @param AuthenticationException $authenticationException
     */
    public function __construct(
        Request $request,
        Response $response,
        AuthenticationException $authenticationException
    )
    {
        $this->request = $request;
        $this->response = $response;
        $this->authenticationException = $authenticationException;
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
     * @return AuthenticationException
     */
    public function getAuthenticationException()
    {
        return $this->authenticationException;
    }
}
