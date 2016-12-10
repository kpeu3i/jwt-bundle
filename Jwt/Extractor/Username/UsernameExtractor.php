<?php

namespace Kpeu3i\JwtBundle\Jwt\Extractor\Username;

use Kpeu3i\JwtBundle\Jwt\Claim\ClaimCollectionInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

/**
 * Class UsernameExtractor
 *
 * @package Kpeu3i\JwtBundle\Jwt\Extractor\Username
 */
class UsernameExtractor implements UsernameExtractorInterface
{
    /**
     * @var
     */
    protected $path;

    /**
     * @var PropertyAccessorInterface
     */
    protected $propertyAccessor;

    /**
     * @param string $path
     * @param PropertyAccessorInterface|null $accessor
     */
    public function __construct($path, PropertyAccessorInterface $accessor = null)
    {
        $this->path = $path;
        $this->propertyAccessor = $accessor ?: PropertyAccess::createPropertyAccessor();
    }

    /**
     * @param ClaimCollectionInterface $claims
     * @param null $default
     * @return mixed|null
     */
    public function extract(ClaimCollectionInterface $claims, $default = null)
    {
        try {
            $value = $this->propertyAccessor->getValue($claims, $this->path);
        } catch (\Exception $e) {
            $value = $default;
        }

        return $value;
    }
}
