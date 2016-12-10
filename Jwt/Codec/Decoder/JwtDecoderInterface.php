<?php

namespace Kpeu3i\JwtBundle\Jwt\Codec\Decoder;

use Kpeu3i\JwtBundle\Jwt\Claim\ClaimCollectionInterface;

/**
 * Interface JwtDecoderInterface
 *
 * @package Kpeu3i\JwtBundle\Jwt\Codec\Decoder
 */
interface JwtDecoderInterface
{
    /**
     * @param string $jwt
     * @param ClaimCollectionInterface $validationClaims
     * @return ClaimCollectionInterface|null
     */
    public function decode($jwt, ClaimCollectionInterface $validationClaims = null);
}
