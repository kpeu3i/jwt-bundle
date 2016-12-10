<?php

namespace Kpeu3i\JwtBundle\Jwt\Extractor\Token;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface JwtTokenExtractorInterface
 *
 * @package Kpeu3i\JwtBundle\Jwt\Extractor\Token
 */
interface JwtTokenExtractorInterface
{
    /**
     * @param Request $request
     * @param mixed|null $default
     * @return mixed
     */
    public function extract(Request $request, $default = null);
}
