<?php

namespace Kpeu3i\JwtBundle\Jwt\Codec\Encoder;

use Kpeu3i\JwtBundle\Jwt\Claim\ClaimCollectionInterface;

interface JwtEncoderInterface
{
    /**
     * @param ClaimCollectionInterface $claims
     * @return string
     */
    public function encode(ClaimCollectionInterface $claims);
}