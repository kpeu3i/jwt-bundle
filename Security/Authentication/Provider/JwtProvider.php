<?php

namespace Kpeu3i\JwtBundle\Security\Authentication\Provider;

use Kpeu3i\JwtBundle\Event\Events;
use Kpeu3i\JwtBundle\Event\JwtValidateEvent;
use Kpeu3i\JwtBundle\Exception\InvalidTokenException;
use Kpeu3i\JwtBundle\Jwt\Codec\Decoder\JwtDecoderInterface;
use Kpeu3i\JwtBundle\Jwt\Extractor\Username\UsernameExtractorInterface;
use Kpeu3i\JwtBundle\Security\Authentication\Token\JwtRawToken;
use Kpeu3i\JwtBundle\Security\Authentication\Token\JwtToken;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Authentication\Provider\AuthenticationProviderInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class JwtProvider implements AuthenticationProviderInterface
{
    /**
     * @var UserProviderInterface
     */
    protected $userProvider;

    /**
     * @var \Kpeu3i\JwtBundle\Jwt\Extractor\Username\UsernameExtractorInterface
     */
    protected $usernameExtractor;

    /**
     * @var JwtDecoderInterface
     */
    protected $decoder;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    public function __construct(
        UserProviderInterface $userProvider,
        UsernameExtractorInterface $usernameExtractor,
        JwtDecoderInterface $decoder,
        EventDispatcherInterface $dispatcher
    )
    {
        $this->userProvider = $userProvider;
        $this->usernameExtractor = $usernameExtractor;
        $this->decoder = $decoder;
        $this->dispatcher = $dispatcher;
    }

    public function authenticate(TokenInterface $token)
    {
        /* @var JwtRawToken $token */
        $jwt = $token->getJwt();

        try {
            $claims = $this->decoder->decode($jwt);
        } catch (InvalidTokenException $e) {
            $claims = null;
        }

        if ($claims) {
            if ($username = $this->usernameExtractor->extract($claims)) {
                if ($user = $this->userProvider->loadUserByUsername($username)) {
                    $this->dispatcher->dispatch(Events::ON_JWT_VALIDATE, new JwtValidateEvent($user, $jwt, $claims));

                    return new JwtToken($user, $jwt, $claims);
                }
            }
        }

        throw new AuthenticationException();
    }

    public function supports(TokenInterface $token)
    {
        return $token instanceof JwtRawToken;
    }
}
