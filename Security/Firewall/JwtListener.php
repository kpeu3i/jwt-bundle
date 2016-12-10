<?php

namespace Kpeu3i\JwtBundle\Security\Firewall;

use Kpeu3i\JwtBundle\Event\Events;
use Kpeu3i\JwtBundle\Event\JwtAuthenticationFailureEvent;
use Kpeu3i\JwtBundle\Event\JwtAuthenticationSuccessEvent;
use Kpeu3i\JwtBundle\Jwt\Extractor\Token\JwtTokenExtractorInterface;
use Kpeu3i\JwtBundle\Security\Authentication\Token\JwtRawToken;
use Kpeu3i\JwtBundle\Security\Authentication\Token\JwtToken;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;

/**
 * Class JwtListener
 *
 * @package Kpeu3i\JwtBundle\Security\Firewall
 */
class JwtListener implements ListenerInterface
{
    /**
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * @var AuthenticationManagerInterface
     */
    protected $authenticationManager;

    /**
     * @var \Kpeu3i\JwtBundle\Jwt\Extractor\Token\JwtTokenExtractorInterface
     */
    protected $tokenExtractor;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @param TokenStorageInterface $tokenStorage
     * @param AuthenticationManagerInterface $authenticationManager
     * @param EventDispatcherInterface $dispatcher
     * @param JwtTokenExtractorInterface $tokenExtractor
     */
    public function __construct(
        TokenStorageInterface $tokenStorage,
        AuthenticationManagerInterface $authenticationManager,
        EventDispatcherInterface $dispatcher,
        JwtTokenExtractorInterface $tokenExtractor
    )
    {
        $this->tokenStorage = $tokenStorage;
        $this->authenticationManager = $authenticationManager;
        $this->tokenExtractor = $tokenExtractor;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function handle(GetResponseEvent $event)
    {
        $request = $event->getRequest();
        $jwt = $this->tokenExtractor->extract($request);
        $token = new JwtRawToken($jwt);

        try {
            /* @var JwtToken $authToken */
            $authToken = $this->authenticationManager->authenticate($token);
            $this->tokenStorage->setToken($authToken);

            $successEvent = new JwtAuthenticationSuccessEvent($request, $authToken);
            $this->dispatcher->dispatch(Events::ON_JWT_AUTHENTICATION_SUCCESS, $successEvent);
        } catch (AuthenticationException $e) {
            $response = new Response();
            $response->setStatusCode(Response::HTTP_FORBIDDEN);

            $failureEvent = new JwtAuthenticationFailureEvent($request, $response, $e);
            $this->dispatcher->dispatch(Events::ON_JWT_AUTHENTICATION_FAILURE, $failureEvent);
            $response = $failureEvent->getResponse();

            $event->setResponse($response);
        }
    }
}
