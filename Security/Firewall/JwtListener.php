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

    public function handle(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        $jwt = $this->tokenExtractor->extract($request);
//
//        $iss = Claim::createIss('http://example.com');
//        $aud = Claim::createAud('http://example.org');
//        $jti = Claim::createJti('4f1g23a12aa');
//        $iat = Claim::createIat(time());
//        $exp = Claim::createExp(time() + 883600);
//        $usr = Claim::create('usr', ['username' => 'admin']);
//
//        $claims = new ClaimCollection();
//        $claims
//            ->set($iss)
//            ->set($aud)
//            ->set($jti)
//            ->set($iat)
//            ->set($exp)
//            ->set($usr)
//        ;
//
//        $validationClaims = new ClaimCollection();
//        $validationClaims
//            ->set($iss)
//            ->set($aud)
//            ->set($jti)
//        ;
//
//        $jwt = $this->jwtManager->encode($claims);
//
//        print_r($jwt);
//
//        print_r("\n");
//        print_r("\n");
//        print_r("\n");
//
//        try {
//            $d = $this->jwtManager->decode($jwt, $validationClaims);
//        } catch (\Exception $e) {
//            $d = $e->getMessage();
//        }
//
//        print_r($d);


        //print_r($this->jwtManager->decode('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImp0aSI6IjRmMWcyM2ExMmFhIn0.eyJpc3MiOiJodHRwOlwvXC9leGFtcGxlLmNvbSIsImF1ZCI6Imh0dHA6XC9cL2V4YW1wbGUub3JnIiwianRpIjoiNGYxZzIzYTEyYWEiLCJpYXQiOjE0NjI0NzI3NzUsIm5iZiI6MTQ2MjQ3MjgzNSwiZXhwIjoxNDYyNDc2Mzc1LCJ1aWQiOjF9.Cu9gUz13nnLiTnwb6xtWatnOyDp35TfE9I3dtJ-V5vQ'));
        //print_r($this->jwtManager->decode('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.W10.n2s6rPl4Q0XjK2oOWIgzgu9W0kT7I4rYxKM2dewbjr0'));
        //print_r($this->jwtManager->decode($jwt, ValidationClaims::create()));

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
