<?php

namespace Kpeu3i\JwtBundle\Jwt\Claim;

/**
 * Class AbstractClaim
 *
 * @package Kpeu3i\JwtBundle\Jwt\Claim
 */
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

    /**
     * @param $name
     * @param $value
     */
    public function __construct($name, $value)
    {
        $this
            ->setName($name)
            ->setValue($value)
        ;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param $value
     * @return $this
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }
}
