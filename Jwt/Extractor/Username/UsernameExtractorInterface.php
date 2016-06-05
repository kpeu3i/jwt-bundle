<?php

namespace Kpeu3i\JwtBundle\Jwt\Extractor\Username;

use Kpeu3i\JwtBundle\Jwt\Claim\ClaimCollectionInterface;

interface UsernameExtractorInterface
{
    public function extract(ClaimCollectionInterface $claims, $default = null);
}