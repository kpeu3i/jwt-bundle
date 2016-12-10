<?php

namespace Kpeu3i\JwtBundle\Jwt\Claim\Factory;

use Kpeu3i\JwtBundle\Jwt\Claim\Claim;
use Kpeu3i\JwtBundle\Jwt\Claim\ClaimCollection;
use Kpeu3i\JwtBundle\Jwt\Claim\ClaimInterface;

/**
 * Class ClaimFactory
 *
 * @package Kpeu3i\JwtBundle\Jwt\Claim\Factory
 */
class ClaimFactory implements ClaimFactoryInterface
{
    /**
     * @param $name
     * @param $value
     * @return Claim
     */
    public function createClaim($name, $value)
    {
        return new Claim($name, $value);
    }

    /**
     * @param array $values
     * @param int|null $ttl
     * @return ClaimCollection
     */
    public function createClaimCollection(array $values = [], $ttl = null)
    {
        $claims = new ClaimCollection();
        foreach ($values as $name => $value) {
            $claim = $this->createClaim($name, $value);
            $claims->set($claim);
        }

        if ($ttl) {
            $time = time();
            $issuedAtClaim = $this->createClaim(ClaimInterface::CLAIM_NAME_IAT, $time);
            $expiredAtClaim = $this->createClaim(ClaimInterface::CLAIM_NAME_EXP, $time + $ttl);

            $claims->set($issuedAtClaim);
            $claims->set($expiredAtClaim);
        }

        return $claims;
    }
}
