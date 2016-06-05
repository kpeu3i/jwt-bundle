<?php

namespace Kpeu3i\JwtBundle\Jwt\Codec\Decoder;

use Kpeu3i\JwtBundle\Exception\InvalidTokenException;
use Kpeu3i\JwtBundle\Jwt\Claim\ClaimCollectionInterface;
use Kpeu3i\JwtBundle\Jwt\Codec\AbstractJwtCodec;

class JwtDecoder extends AbstractJwtCodec implements JwtDecoderInterface
{
    public function decode($jwt, ClaimCollectionInterface $validationClaims = null)
    {
        $key = $this->createKey($this->key, $this->passphrase);
        $signer = $this->createSigner($this->algorithm);
        $parser = $this->createParser();
        $jwt = (string)$jwt;

        $claimCollection = null;
        $cause = null;
        try {
            $token = $parser->parse($jwt);
            if ($token->verify($signer, $key)) {
                $validationData = $this->createValidationData($validationClaims);
                if ($token->validate($validationData)) {
                    $claimCollection = $this->createClaimCollection($token);
                }
            }
        } catch (\Exception $e) {
            $cause = $e;
        }

        if (!$claimCollection) {
            throw new InvalidTokenException();
        }

        return $claimCollection;
    }
}
