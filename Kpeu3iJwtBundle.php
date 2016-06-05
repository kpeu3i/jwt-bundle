<?php

namespace Kpeu3i\JwtBundle;

use Kpeu3i\JwtBundle\DependencyInjection\Security\Factory\JwtCreationFactory;
use Kpeu3i\JwtBundle\DependencyInjection\Security\Factory\JwtFactory;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class Kpeu3iJwtBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $extension = $container->getExtension('security');
        $extension->addSecurityListenerFactory(new JwtFactory());
        $extension->addSecurityListenerFactory(new JwtCreationFactory());
    }
}
