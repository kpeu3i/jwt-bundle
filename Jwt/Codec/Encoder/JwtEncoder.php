<?php

namespace Kpeu3i\JwtBundle\Jwt\Codec\Encoder;

use Kpeu3i\JwtBundle\Jwt\Claim\ClaimCollectionInterface;
use Kpeu3i\JwtBundle\Jwt\Codec\AbstractJwtCodec;

class JwtEncoder extends AbstractJwtCodec implements JwtEncoderInterface
{
    public function encode(ClaimCollectionInterface $claims)
    {
        $key = $this->createKey($this->key, $this->passphrase);
        $signer = $this->createSigner($this->algorithm);
        $builder = $this->createBuilder($claims);
        $builder->sign($signer, $key);

        return (string)$builder->getToken();
    }
}
