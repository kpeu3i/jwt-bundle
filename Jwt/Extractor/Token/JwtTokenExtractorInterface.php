<?php

namespace Kpeu3i\JwtBundle\Jwt\Extractor\Token;

use Symfony\Component\HttpFoundation\Request;

interface JwtTokenExtractorInterface
{
    public function extract(Request $request, $default = null);
}