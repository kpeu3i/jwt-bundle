<?php

namespace Kpeu3i\JwtBundle\Jwt\Claim;

class ClaimCollection implements ClaimCollectionInterface
{
    protected $claims = [];

    public function __get($name)
    {
        return $this->get($name);
    }

    public function __set($name, ClaimInterface $value)
    {
        return $this->set($value);
    }

    public function get($name)
    {
        return $this->has($name) ? $this->claims[$name] : null;
    }

    public function has($name)
    {
        return array_key_exists($name, $this->claims);
    }

    public function set(ClaimInterface $claim)
    {
        $this->claims[$claim->getName()] = $claim;

        return $this;
    }

    public function remove($name)
    {
        if ($exists = $this->has($name)) {
            unset($this->claims[$name]);
        }

        return $exists;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->claims);
    }
}
