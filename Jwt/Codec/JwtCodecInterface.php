<?php

namespace Kpeu3i\JwtBundle\Jwt\Codec;

/**
 * Interface JwtCodecInterface
 *
 * @package Kpeu3i\JwtBundle\Jwt\Codec
 */
interface JwtCodecInterface
{
    // HMAC
    const ALGORITHM_HS256 = 'HS256';
    const ALGORITHM_HS384 = 'HS384';
    const ALGORITHM_HS512 = 'HS512';

    // RSA
    const ALGORITHM_RS256 = 'RS256';
    const ALGORITHM_RS384 = 'RS384';
    const ALGORITHM_RS512 = 'RS512';

    // ECDSA
    const ALGORITHM_ES256 = 'ES256';
    const ALGORITHM_ES384 = 'ES384';
    const ALGORITHM_ES512 = 'ES512';
}
