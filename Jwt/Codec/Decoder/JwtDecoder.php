<?php

namespace Kpeu3i\JwtBundle\Jwt\Codec\Decoder;

use Kpeu3i\JwtBundle\Exception\InvalidTokenException;
use Kpeu3i\JwtBundle\Jwt\Claim\ClaimCollectionInterface;
use Kpeu3i\JwtBundle\Jwt\Codec\AbstractJwtCodec;

/**
 * Class JwtDecoder
 *
 * @package Kpeu3i\JwtBundle\Jwt\Codec\Decoder
 */
class JwtDecoder extends AbstractJwtCodec implements JwtDecoderInterface
{
    /**
     * @param string $jwt
     * @param ClaimCollectionInterface|null $validationClaims
     * @return ClaimCollectionInterface|null
     * @throws InvalidTokenException
     */
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
