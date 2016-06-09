<?php

namespace Kpeu3i\JwtBundle\DependencyInjection\Security\Factory;

use Kpeu3i\JwtBundle\Jwt\Codec\JwtCodecInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;

class JwtFactory implements SecurityFactoryInterface
{
    public function create(ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint)
    {
        // ClaimFactory
        $claimFactoryId = 'kpeu3i_jwt.claim.factory.' . $id;
        $container
            ->setDefinition($claimFactoryId, new DefinitionDecorator('kpeu3i_jwt.claim.factory'))
        ;

        // Decoder
        $decoderId = 'kpeu3i_jwt.decoder.' . $id;
        $container
            ->setDefinition($decoderId, new DefinitionDecorator('kpeu3i_jwt.decoder'))
            ->replaceArgument(0, $config['decoder']['key'])
            ->replaceArgument(2, $config['decoder']['algorithm'])
            ->replaceArgument(3, new Reference($claimFactoryId))
        ;

        // UsernameExtractor
        $usernameExtractorId = 'kpeu3i_jwt.username.extractor.' . $id;
        $container
            ->setDefinition($usernameExtractorId, new DefinitionDecorator('kpeu3i_jwt.username.extractor'))
            ->replaceArgument(0, $config['username_extractor']['path'])
        ;

        // TokenExtractor
        $resolvedExtractorId = sprintf('kpeu3i_jwt.token.extractor.%s', $config['token_extractor']['type']);
        $tokenExtractorId = $resolvedExtractorId . '.' . $id;
        $container
            ->setDefinition($tokenExtractorId, new DefinitionDecorator($resolvedExtractorId))
            ->replaceArgument(0, $config['token_extractor']['parameter_name'])
            ->replaceArgument(1, $config['token_extractor']['token_prefix']);
        ;

        // Provider
        $providerId = 'kpeu3i_jwt.security.authentication.provider.jwt.' . $id;
        $container
            ->setDefinition($providerId, new DefinitionDecorator('kpeu3i_jwt.security.authentication.provider'))
            ->replaceArgument(0, new Reference($userProvider))
            ->replaceArgument(1, new Reference($usernameExtractorId))
            ->replaceArgument(2, new Reference($decoderId))
        ;

        // Listener
        $listenerId = 'security.authentication.listener.kpeu3i_jwt.' . $id;
        $container
            ->setDefinition($listenerId, new DefinitionDecorator('kpeu3i_jwt.security.authentication.listener'))
            ->replaceArgument(3, new Reference($tokenExtractorId))
        ;

        return [$providerId, $listenerId, $defaultEntryPoint];
    }

    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('decoder')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('algorithm')
                            ->defaultValue(JwtCodecInterface::ALGORITHM_HS256)
                        ->end()
                        ->scalarNode('key')
                            ->defaultNull()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('token_extractor')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('type')
                            ->defaultValue('headers')
                        ->end()
                        ->scalarNode('parameter_name')
                            ->defaultValue('Authorization')
                        ->end()
                        ->scalarNode('token_prefix')
                            ->defaultValue('Bearer')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('username_extractor')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('path')
                            ->defaultValue('usr.value.username')
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    public function getPosition()
    {
        return 'pre_auth';
    }

    public function getKey()
    {
        return 'kpeu3i_jwt';
    }
}