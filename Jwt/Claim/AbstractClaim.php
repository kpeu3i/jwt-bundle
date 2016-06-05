<?php

namespace Kpeu3i\JwtBundle\Jwt\Claim;

abstract class AbstractClaim implements ClaimInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $value;

    public function __construct($name, $value)
    {
        $this
            ->setName($name)
            ->setValue($value)
        ;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getValue()
    {
        return $this->value;
    }

    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
