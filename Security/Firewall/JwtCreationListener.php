<?php

namespace Kpeu3i\JwtBundle\Security\Firewall;

use Kpeu3i\JwtBundle\Event\AuthenticationFailureEvent;
use Kpeu3i\JwtBundle\Event\AuthenticationSuccessEvent;
use Kpeu3i\JwtBundle\Event\Events;
use Kpeu3i\JwtBundle\Jwt\Extractor\Credentials\CredentialsExtractorInterface;
use Kpeu3i\JwtBundle\Security\Authentication\Token\JwtToken;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Firewall\ListenerInterface;

/**
 * Class JwtCreationListener
 *
 * @package Kpeu3i\JwtBundle\Security\Firewall
 */
class JwtCreationListener implements ListenerInterface
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
     * @var CredentialsExtractorInterface
     */
    protected $credentialsExtractor;

    /**
     * @var string
     */
    protected $providerKey;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * JwtCreationListener constructor.
     * @param TokenStorageInterface $tokenStorage
     * @param AuthenticationManagerInterface $authenticationManager
     * @param CredentialsExtractorInterface $credentialsExtractor
     * @param EventDispatcherInterface $dispatcher
     * @param $providerKey
     */
    public function __construct (
        TokenStorageInterface $tokenStorage,
        AuthenticationManagerInterface $authenticationManager,
        CredentialsExtractorInterface $credentialsExtractor,
        EventDispatcherInterface $dispatcher,
        $providerKey
    )
    {
        $this->tokenStorage = $tokenStorage;
        $this->authenticationManager = $authenticationManager;
        $this->credentialsExtractor = $credentialsExtractor;
        $this->providerKey = $providerKey;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param GetResponseEvent $event
     */
    public function handle(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        $username = $this->credentialsExtractor->extractUsername($request);
        $password = $this->credentialsExtractor->extractPassword($request);

        if ($username === null) {
            return;
        }

        $token = new UsernamePasswordToken($username, $password, $this->providerKey);
        $response = new Response();

        try {
            /* @var JwtToken $authToken */
            $authToken = $this->authenticationManager->authenticate($token);
            $this->tokenStorage->setToken($authToken);
            $response->setContent($authToken->getJwt());

            $authenticationSuccessEvent = new AuthenticationSuccessEvent($request, $response, $authToken);
            $this->dispatcher->dispatch(Events::ON_AUTHENTICATION_SUCCESS, $authenticationSuccessEvent);
            $response = $authenticationSuccessEvent->getResponse();
        } catch (AuthenticationException $e) {
            $response->setStatusCode(Response::HTTP_FORBIDDEN);

            $authenticationFailureEvent = new AuthenticationFailureEvent($request, $response, $e);
            $this->dispatcher->dispatch(Events::ON_AUTHENTICATION_FAILURE, $authenticationFailureEvent);
            $response = $authenticationFailureEvent->getResponse();
        }

        $event->setResponse($response);
    }
}
