<?php

namespace Kpeu3i\JwtBundle\Jwt\Extractor\Token;

/**
 * Class AbstractJwtTokenExtractor
 *
 * @package Kpeu3i\JwtBundle\Jwt\Extractor\Token
 */
abstract class AbstractJwtTokenExtractor implements JwtTokenExtractorInterface
{
    /**
     * @var string
     */
    protected $parameterName;

    /**
     * @var string
     */
    protected $tokenPrefix;

    /**
     * @param string $parameterName
     * @param string $tokenPrefix
     */
    public function __construct($parameterName, $tokenPrefix = '')
    {
        $this
            ->setParameterName($parameterName)
            ->setTokenPrefix($tokenPrefix)
        ;
    }

    /**
     * @param string $parameterName
     * @return $this
     */
    public function setParameterName($parameterName)
    {
        $this->parameterName = (string)$parameterName;

        return $this;
    }

    /**
     * @param string $tokenPrefix
     */
    public function setTokenPrefix($tokenPrefix)
    {
        $this->tokenPrefix = (string)$tokenPrefix;
    }

    /**
     * @param string $str
     * @param string $prefix
     * @param mixed|null $default
     * @return string
     */
    protected function extractFromString($str, $prefix, $default = null)
    {
        $prefix = (string)$prefix;
        $token = $str;

        if ($prefix) {
            $headerParts = explode(' ', $str);
            $token = count($headerParts) === 2 && $headerParts[0] === $prefix ? $headerParts[1] : $default;
        }

        return $token;
    }
}
