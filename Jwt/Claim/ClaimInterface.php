<?php

namespace Kpeu3i\JwtBundle\Jwt\Claim;

/**
 * Interface ClaimInterface
 *
 * @package Kpeu3i\JwtBundle\Jwt\Claim
 */
interface ClaimInterface
{
    const CLAIM_NAME_JTI = 'jti';
    const CLAIM_NAME_ISS = 'iss';
    const CLAIM_NAME_AUD = 'aud';
    const CLAIM_NAME_SUB = 'sub';
    const CLAIM_NAME_IAT = 'iat';
    const CLAIM_NAME_NBF = 'nbf';
    const CLAIM_NAME_EXP = 'exp';

    /**
     * @return mixed
     */
    public function getName();

    /**
     * @return mixed
     */
    public function getValue();

    /**
     * @param $value
     * @return mixed
     */
    public function setValue($value);
}
