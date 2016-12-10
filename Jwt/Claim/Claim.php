<?php

namespace Kpeu3i\JwtBundle\Jwt\Claim;

/**
 * Class Claim
 *
 * @package Kpeu3i\JwtBundle\Jwt\Claim
 */
class Claim extends AbstractClaim
{
    /**
     * @param $name
     * @param $value
     * @return static
     */
    public static function create($name, $value)
    {
        return new static($name, $value);
    }

    /**
     * @param $value
     * @return Claim
     */
    public static function createJti($value)
    {
        return static::create(ClaimInterface::CLAIM_NAME_JTI, $value);
    }

    /**
     * @param $value
     * @return Claim
     */
    public static function createIss($value)
    {
        return static::create(ClaimInterface::CLAIM_NAME_ISS, $value);
    }

    /**
     * @param $value
     * @return Claim
     */
    public static function createAud($value)
    {
        return static::create(ClaimInterface::CLAIM_NAME_AUD, $value);
    }

    /**
     * @param $value
     * @return Claim
     */
    public static function createSub($value)
    {
        return static::create(ClaimInterface::CLAIM_NAME_SUB, $value);
    }

    /**
     * @param $value
     * @return Claim
     */
    public static function createIat($value)
    {
        return static::create(ClaimInterface::CLAIM_NAME_IAT, $value);
    }

    /**
     * @param $value
     * @return Claim
     */
    public static function createNbf($value)
    {
        return static::create(ClaimInterface::CLAIM_NAME_NBF, $value);
    }

    /**
     * @param $value
     * @return Claim
     */
    public static function createExp($value)
    {
        return static::create(ClaimInterface::CLAIM_NAME_EXP, $value);
    }
}
