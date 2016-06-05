<?php

namespace Kpeu3i\JwtBundle\Jwt\Extractor\Username;

use Kpeu3i\JwtBundle\Jwt\Claim\ClaimCollectionInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;

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

    public function __construct($path, PropertyAccessorInterface $accessor = null)
    {
        $this->path = $path;
        $this->propertyAccessor = $accessor ?: PropertyAccess::createPropertyAccessor();
    }

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
