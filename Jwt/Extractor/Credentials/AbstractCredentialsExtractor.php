<?php

namespace Kpeu3i\JwtBundle\Jwt\Extractor\Credentials;

/**
 * Class AbstractCredentialsExtractor
 *
 * @package Kpeu3i\JwtBundle\Jwt\Extractor\Credentials
 */
abstract class AbstractCredentialsExtractor implements CredentialsExtractorInterface
{
    /**
     * @var string
     */
    protected $usernameParameter;

    /**
     * @var string
     */
    protected $passwordParameter;

    /**
     * @param string $usernameParameter
     * @param string $passwordParameter
     */
    public function __construct($usernameParameter, $passwordParameter)
    {
        $this
            ->setUsernameParameter($usernameParameter)
            ->setPasswordParameter($passwordParameter)
        ;
    }

    /**
     * @param string $usernameParameter
     * @return $this
     */
    public function setUsernameParameter($usernameParameter)
    {
        $this->usernameParameter = (string)$usernameParameter;

        return $this;
    }

    /**
     * @param string $passwordParameter
     */
    public function setPasswordParameter($passwordParameter)
    {
        $this->passwordParameter = $passwordParameter;
    }
}
