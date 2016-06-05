<?php

namespace Kpeu3i\JwtBundle\Jwt\Claim;

interface ClaimInterface
{
    const CLAIM_NAME_JTI = 'jti';
    const CLAIM_NAME_ISS = 'iss';
    const CLAIM_NAME_AUD = 'aud';
    const CLAIM_NAME_SUB = 'sub';
    const CLAIM_NAME_IAT = 'iat';
    const CLAIM_NAME_NBF = 'nbf';
    const CLAIM_NAME_EXP = 'exp';

    public function getName();

    public function getValue();

    public function setValue($value);
}
