<?php

namespace Kpeu3i\JwtBundle\Jwt\Extractor\Credentials;

use Symfony\Component\HttpFoundation\Request;

interface CredentialsExtractorInterface
{
    public function extractUsername(Request $request, $default = null);

    public function extractPassword(Request $request, $default = null);
}