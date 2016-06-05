<?php

namespace Kpeu3i\JwtBundle\Jwt\Claim\Factory;

use Kpeu3i\JwtBundle\Jwt\Claim\Claim;
use Kpeu3i\JwtBundle\Jwt\Claim\ClaimCollection;
use Kpeu3i\JwtBundle\Jwt\Claim\ClaimInterface;

class ClaimFactory implements ClaimFactoryInterface
{
    public function createClaim($name, $value)
    {
        return new Claim($name, $value);
    }

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
