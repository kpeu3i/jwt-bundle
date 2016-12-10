<?php

namespace Kpeu3i\JwtBundle\Jwt\Extractor\Token;

use Symfony\Component\HttpFoundation\Request;

/**
 * Class HeadersJwtTokenExtractor
 *
 * @package Kpeu3i\JwtBundle\Jwt\Extractor\Token
 */
class HeadersJwtTokenExtractor extends AbstractJwtTokenExtractor
{
    /**
     * @param Request $request
     * @param mixed|null $default
     * @return string
     */
    public function extract(Request $request, $default = null)
    {
        $token = $request->headers->get($this->parameterName, $default);

        return $this->extractFromString($token, $this->tokenPrefix, $default);
    }
}
