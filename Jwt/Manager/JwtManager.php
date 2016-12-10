<?php

namespace Kpeu3i\JwtBundle\Jwt\Manager;

use Kpeu3i\JwtBundle\Jwt\Claim\ClaimCollectionInterface;
use Kpeu3i\JwtBundle\Jwt\Codec\Decoder\JwtDecoderInterface;
use Kpeu3i\JwtBundle\Jwt\Codec\Encoder\JwtEncoderInterface;

/**
 * Class JwtManager
 *
 * @package Kpeu3i\JwtBundle\Jwt\Manager
 */
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

    /**
     * @param JwtEncoderInterface $encoder
     * @param JwtDecoderInterface $decoder
     */
    public function __construct(JwtEncoderInterface $encoder, JwtDecoderInterface $decoder)
    {
        $this->encoder = $encoder;
        $this->decoder = $decoder;
    }

    /**
     * @param ClaimCollectionInterface $claims
     * @return string
     */
    public function encode(ClaimCollectionInterface $claims)
    {
        return $this->encoder->encode($claims);
    }

    /**
     * @param string $jwt
     * @param ClaimCollectionInterface|null $validationClaims
     * @return ClaimCollectionInterface|null
     */
    public function decode($jwt, ClaimCollectionInterface $validationClaims = null)
    {
        return $this->decoder->decode($jwt, $validationClaims);
    }
}
