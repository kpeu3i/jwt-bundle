<?php

namespace Kpeu3i\JwtBundle\DependencyInjection;

use Kpeu3i\JwtBundle\Jwt\Codec\Encoder\JwtEncoderInterface;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('kpeu3i_jwt');
//
//        $rootNode
//            ->addDefaultsIfNotSet()
//            ->children()
//
//
//                ->scalarNode('ttl')
//                    ->defaultValue(86400)
//                ->end()
//
//                ->arrayNode('encoder')
//                    ->addDefaultsIfNotSet()
//                    ->children()
//                        ->scalarNode('algorithm')
//                            ->defaultValue(JwtEncoderInterface::ALGORITHM_HS256)
//                        ->end()
//                        ->scalarNode('secret_key')
//                            ->defaultValue(null)
//                        ->end()
//                        ->scalarNode('ssl_private_key')
//                            ->defaultValue(null)
//                        ->end()
//                        ->scalarNode('ssl_public_key')
//                            ->defaultValue(null)
//                        ->end()
//                        ->scalarNode('ssl_passphrase')
//                            ->defaultValue(null)
//                        ->end()
//                    ->end()
//                ->end()
//
//                ->arrayNode('extractor')
//                    ->addDefaultsIfNotSet()
//                    ->children()
//                        ->scalarNode('source')
//                            ->defaultValue('headers')
//                        ->end()
//                        ->scalarNode('parameter_name')
//                            ->defaultValue('Authorization')
//                        ->end()
//                        ->scalarNode('token_prefix')
//                            ->defaultValue('Bearer')
//                        ->end()
//                    ->end()
//                ->end()
//
//            ->end();

        return $treeBuilder;
    }
}
