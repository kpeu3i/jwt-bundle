<?php

namespace Kpeu3i\JwtBundle\Jwt\Extractor\Token;

use Symfony\Component\HttpFoundation\Request;

class HeadersJwtTokenExtractor extends AbstractJwtTokenExtractor
{
    public function extract(Request $request, $default = null)
    {
        $token = $request->headers->get($this->parameterName, $default);

        return $this->extractFromString($token, $this->tokenPrefix, $default);
    }
}