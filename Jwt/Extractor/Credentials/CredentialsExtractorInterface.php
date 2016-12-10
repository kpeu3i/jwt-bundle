<?php

namespace Kpeu3i\JwtBundle\Jwt\Extractor\Credentials;

use Symfony\Component\HttpFoundation\Request;

/**
 * Interface CredentialsExtractorInterface
 *
 * @package Kpeu3i\JwtBundle\Jwt\Extractor\Credentials
 */
interface CredentialsExtractorInterface
{
    /**
     * @param Request $request
     * @param mixed|null $default
     * @return mixed
     */
    public function extractUsername(Request $request, $default = null);

    /**
     * @param Request $request
     * @param mixed|null $default
     * @return mixed
     */
    public function extractPassword(Request $request, $default = null);
}
