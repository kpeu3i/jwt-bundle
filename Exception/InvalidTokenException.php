<?php

namespace Kpeu3i\JwtBundle\Exception;

/**
 * Class InvalidTokenException
 *
 * @package Kpeu3i\JwtBundle\Exception
 */
class InvalidTokenException extends \Exception
{
    /**
     * @var \Exception
     */
    protected $cause;

    public function __construct(\Exception $cause = null)
    {
        $this->cause = $cause;
    }

    /**
     * @return \Exception
     */
    public function getCause()
    {
        return $this->cause;
    }
}
