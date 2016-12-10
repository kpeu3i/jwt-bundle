<?php

namespace Kpeu3i\JwtBundle\Jwt\Claim;

/**
 * Interface ClaimCollectionInterface
 *
 * @package Kpeu3i\JwtBundle\Jwt\Claim
 */
interface ClaimCollectionInterface extends \IteratorAggregate
{
    /**
     * @param $name
     * @return mixed
     */
    public function get($name);

    /**
     * @param $name
     * @return mixed
     */
    public function has($name);

    /**
     * @param ClaimInterface $claim
     * @return mixed
     */
    public function set(ClaimInterface $claim);

    /**
     * @param $name
     * @return mixed
     */
    public function remove($name);
}
