<?php

namespace Kpeu3i\JwtBundle\Jwt\Claim;

/**
 * Class ClaimCollection
 *
 * @package Kpeu3i\JwtBundle\Jwt\Claim
 */
class ClaimCollection implements ClaimCollectionInterface
{
    /**
     * @var array
     */
    protected $claims = [];

    /**
     * @param $name
     * @return mixed|null
     */
    public function __get($name)
    {
        return $this->get($name);
    }

    /**
     * @param $name
     * @param ClaimInterface $value
     * @return ClaimCollection
     */
    public function __set($name, ClaimInterface $value)
    {
        return $this->set($value);
    }

    /**
     * @param $name
     * @return mixed|null
     */
    public function get($name)
    {
        return $this->has($name) ? $this->claims[$name] : null;
    }

    /**
     * @param $name
     * @return bool
     */
    public function has($name)
    {
        return array_key_exists($name, $this->claims);
    }

    /**
     * @param ClaimInterface $claim
     * @return $this
     */
    public function set(ClaimInterface $claim)
    {
        $this->claims[$claim->getName()] = $claim;

        return $this;
    }

    /**
     * @param $name
     * @return bool
     */

    public function remove($name)
    {
        if ($exists = $this->has($name)) {
            unset($this->claims[$name]);
        }

        return $exists;
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->claims);
    }
}
