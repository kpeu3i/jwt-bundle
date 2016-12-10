<?php

namespace Kpeu3i\JwtBundle\Jwt\Claim\Factory;

use Kpeu3i\JwtBundle\Jwt\Claim\ClaimCollectionInterface;
use Kpeu3i\JwtBundle\Jwt\Claim\ClaimInterface;

/**
 * Interface ClaimFactoryInterface
 *
 * @package Kpeu3i\JwtBundle\Jwt\Claim\Factory
 */
interface ClaimFactoryInterface
{
    /**
     * @param array $values
     * @param int|null $ttl
     * @return ClaimCollectionInterface
     */
    public function createClaimCollection(array $values = [], $ttl = null);

    /**
     * @param $name
     * @param $value
     * @return ClaimInterface
     */
    public function createClaim($name, $value);
}
