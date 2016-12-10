<?php

namespace Kpeu3i\JwtBundle\Jwt\Codec\Encoder;

use Kpeu3i\JwtBundle\Jwt\Claim\ClaimCollectionInterface;
use Kpeu3i\JwtBundle\Jwt\Codec\AbstractJwtCodec;

/**
 * Class JwtEncoder
 *
 * @package Kpeu3i\JwtBundle\Jwt\Codec\Encoder
 */
class JwtEncoder extends AbstractJwtCodec implements JwtEncoderInterface
{
    /**
     * @param ClaimCollectionInterface $claims
     * @return string
     */
    public function encode(ClaimCollectionInterface $claims)
    {
        $key = $this->createKey($this->key, $this->passphrase);
        $signer = $this->createSigner($this->algorithm);
        $builder = $this->createBuilder($claims);
        $builder->sign($signer, $key);

        return (string)$builder->getToken();
    }
}
