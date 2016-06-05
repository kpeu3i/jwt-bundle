<?php

namespace Kpeu3i\JwtBundle\Jwt\Claim;

class Claim extends AbstractClaim
{
    public static function create($name, $value)
    {
        return new static($name, $value);
    }

    public static function createJti($value)
    {
        return static::create(ClaimInterface::CLAIM_NAME_JTI, $value);
    }

    public static function createIss($value)
    {
        return static::create(ClaimInterface::CLAIM_NAME_ISS, $value);
    }

    public static function createAud($value)
    {
        return static::create(ClaimInterface::CLAIM_NAME_AUD, $value);
    }

    public static function createSub($value)
    {
        return static::create(ClaimInterface::CLAIM_NAME_SUB, $value);
    }

    public static function createIat($value)
    {
        return static::create(ClaimInterface::CLAIM_NAME_IAT, $value);
    }

    public static function createNbf($value)
    {
        return static::create(ClaimInterface::CLAIM_NAME_NBF, $value);
    }

    public static function createExp($value)
    {
        return static::create(ClaimInterface::CLAIM_NAME_EXP, $value);
    }
}
