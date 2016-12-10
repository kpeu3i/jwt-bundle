<?php

namespace Kpeu3i\JwtBundle\Jwt\Extractor\Username;

use Kpeu3i\JwtBundle\Jwt\Claim\ClaimCollectionInterface;

/**
 * Interface UsernameExtractorInterface
 *
 * @package Kpeu3i\JwtBundle\Jwt\Extractor\Username
 */
interface UsernameExtractorInterface
{
    /**
     * @param ClaimCollectionInterface $claims
     * @param null $default
     * @return mixed
     */
    public function extract(ClaimCollectionInterface $claims, $default = null);
}
