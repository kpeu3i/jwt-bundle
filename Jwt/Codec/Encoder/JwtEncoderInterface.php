<?php

namespace Kpeu3i\JwtBundle\Jwt\Codec\Encoder;

use Kpeu3i\JwtBundle\Jwt\Claim\ClaimCollectionInterface;

/**
 * Interface JwtEncoderInterface
 *
 * @package Kpeu3i\JwtBundle\Jwt\Codec\Encoder
 */
interface JwtEncoderInterface
{
    /**
     * @param ClaimCollectionInterface $claims
     * @return string
     */
    public function encode(ClaimCollectionInterface $claims);
}
