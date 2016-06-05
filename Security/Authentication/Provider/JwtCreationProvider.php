<?php

namespace Kpeu3i\JwtBundle\Security\Authentication\Provider;

use Kpeu3i\JwtBundle\Event\Events;
use Kpeu3i\JwtBundle\Event\JwtCreateEvent;
use Kpeu3i\JwtBundle\Jwt\Claim\Factory\ClaimFactoryInterface;
use Kpeu3i\JwtBundle\Jwt\Codec\Encoder\JwtEncoderInterface;
use Kpeu3i\JwtBundle\Security\Authentication\Token\JwtToken;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\Security\Core\Authentication\Provider\DaoAuthenticationProvider;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class JwtCreationProvider extends DaoAuthenticationProvider
{
    /**
     * @var UserProviderInterface
     */
    protected $userProvider;

    /**
     * @var JwtEncoderInterface
     */
    protected $encoder;

    /**
     * @var ClaimFactoryInterface
     */
    protected $factory;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * @var array
     */
    protected $tokenConfig;

    /**
     * @var \Symfony\Component\PropertyAccess\PropertyAccessor
     */
    protected $propertyAccessor;

    public function __construct(
        UserProviderInterface $userProvider,
        UserCheckerInterface $userChecker,
        EncoderFactoryInterface $encoderFactory,
        JwtEncoderInterface $encoder,
        ClaimFactoryInterface $factory,
        EventDispatcherInterface $dispatcher,
        $tokenConfig,
        $providerKey,
        PropertyAccessorInterface $propertyAccessor = null,
        $hideUserNotFoundExceptions = true
    )
    {
        parent::__construct($userProvider, $userChecker, $providerKey, $encoderFactory, $hideUserNotFoundExceptions);

        $this->encoder = $encoder;
        $this->factory = $factory;
        $this->dispatcher = $dispatcher;
        $this->tokenConfig = $tokenConfig;
        $this->propertyAccessor = $propertyAccessor ?: PropertyAccess::createPropertyAccessor();
    }

    public function authenticate(TokenInterface $token)
    {
        $usernamePasswordToken = parent::authenticate($token);

        $user = $usernamePasswordToken->getUser();
        $claims = $this->createClaimCollection($user);

        $event = $this->dispatcher->dispatch(Events::ON_JWT_CREATE, new JwtCreateEvent($user, $claims));
        $claims = $event->getClaims();

        $jwt = $this->encoder->encode($claims);

        return new JwtToken($user, $jwt, $claims);
    }

    protected function createClaimCollection(UserInterface $user)
    {
        $ttl = isset($this->tokenConfig['ttl']) ? $this->tokenConfig['ttl'] : null;
        $claimsData = isset($this->tokenConfig['claims']) ? $this->tokenConfig['claims'] : [];

        $values = [];
        foreach ($claimsData as $key => $claimData) {
            if (isset($claimData['name']) && isset($claimData['value'])) {
                if ($key == 'user') {
                    $this->propertyAccessor->setValue(
                        $values,
                        $claimData['name'],
                        $this->propertyAccessor->getValue($user, $claimData['value'])
                    );
                } else {
                    $values[$claimData['name']] = $claimData['value'];
                }
            }
        }

        return $this->factory->createClaimCollection($values,  $ttl);
    }

    public function supports(TokenInterface $token)
    {
        return $token instanceof UsernamePasswordToken;
    }
}
