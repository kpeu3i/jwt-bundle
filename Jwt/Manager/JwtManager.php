<?php

namespace Kpeu3i\JwtBundle\Jwt\Manager;

use Kpeu3i\JwtBundle\Jwt\Claim\ClaimCollectionInterface;
use Kpeu3i\JwtBundle\Jwt\Codec\Decoder\JwtDecoderInterface;
use Kpeu3i\JwtBundle\Jwt\Codec\Encoder\JwtEncoderInterface;

class JwtManager implements JwtManagerInterface
{
    /**
     * @var JwtEncoderInterface
     */
    protected $encoder;

    /**
     * @var JwtDecoderInterface
     */
    protected $decoder;

    public function __construct(JwtEncoderInterface $encoder, JwtDecoderInterface $decoder)
    {
        $this->encoder = $encoder;
        $this->decoder = $decoder;
    }

    public function encode(ClaimCollectionInterface $claims)
    {
        return $this->encoder->encode($claims);
    }

    public function decode($jwt, ClaimCollectionInterface $validationClaims = null)
    {
        return $this->decoder->decode($jwt, $validationClaims);
    }
}
