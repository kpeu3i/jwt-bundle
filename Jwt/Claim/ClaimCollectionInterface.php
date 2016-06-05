<?php

namespace Kpeu3i\JwtBundle\Jwt\Claim;

interface ClaimCollectionInterface extends \IteratorAggregate
{
    public function get($name);

    public function has($name);

    public function set(ClaimInterface $claim);

    public function remove($name);
}
