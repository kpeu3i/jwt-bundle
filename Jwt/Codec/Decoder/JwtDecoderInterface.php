<?php

namespace Kpeu3i\JwtBundle\Jwt\Codec\Decoder;

use Kpeu3i\JwtBundle\Jwt\Claim\ClaimCollectionInterface;

interface JwtDecoderInterface
{
    /**
     * @param $jwt
     * @param ClaimCollectionInterface $validationClaims
     * @return ClaimCollectionInterface|null
     */
    public function decode($jwt, ClaimCollectionInterface $validationClaims = null);
}