<?php

namespace Kpeu3i\JwtBundle\DependencyInjection\Security\Factory;

use Kpeu3i\JwtBundle\Jwt\Claim\ClaimInterface;
use Kpeu3i\JwtBundle\Jwt\Codec\JwtCodecInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\SecurityFactoryInterface;

class JwtCreationFactory implements SecurityFactoryInterface
{
    public function create(ContainerBuilder $container, $id, $config, $userProvider, $defaultEntryPoint)
    {
        // ClaimFactory
        $claimFactoryId = 'kpeu3i_jwt.claim.factory.' . $id;
        $container
            ->setDefinition($claimFactoryId, new DefinitionDecorator('kpeu3i_jwt.claim.factory'))
        ;

        // Encoder
        $encoderId = 'kpeu3i_jwt.encoder.' . $id;
        $container
            ->setDefinition($encoderId, new DefinitionDecorator('kpeu3i_jwt.encoder'))
            ->replaceArgument(0, $config['encoder']['key'])
            ->replaceArgument(1, $config['encoder']['passphrase'])
            ->replaceArgument(2, $config['encoder']['algorithm'])
            ->replaceArgument(3, new Reference($claimFactoryId))
        ;

        // CredentialsExtractor
        $resolvedCredentialsExtractorId = sprintf('kpeu3i_jwt.credentials.extractor.%s', $config['credentials_extractor']['type']);
        $credentialsExtractorId = $resolvedCredentialsExtractorId . '.' . $id;
        $container
            ->setDefinition($credentialsExtractorId, new DefinitionDecorator($resolvedCredentialsExtractorId))
            ->replaceArgument(0, $config['credentials_extractor']['username_parameter'])
            ->replaceArgument(1, $config['credentials_extractor']['password_parameter']);
        ;

        // Provider
        $providerId = 'kpeu3i_jwt.security.authentication.provider.creation.' . $id;
        $container
            ->setDefinition($providerId, new DefinitionDecorator('kpeu3i_jwt.security.authentication.provider.creation'))
            ->replaceArgument(0, new Reference($userProvider))
            ->replaceArgument(3, new Reference($encoderId))
            ->replaceArgument(4, new Reference($claimFactoryId))
            ->replaceArgument(6, $config['token'])
            ->replaceArgument(7, $id)
        ;

        // Listener
        $listenerId = 'security.authentication.listener.kpeu3i_jwt.' . $id;
        $container
            ->setDefinition($listenerId, new DefinitionDecorator('kpeu3i_jwt.security.authentication.listener.creation'))
            ->replaceArgument(2, new Reference($credentialsExtractorId))
            ->replaceArgument(4, $id)
        ;

        return [$providerId, $listenerId, $defaultEntryPoint];
    }

    public function addConfiguration(NodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('encoder')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('algorithm')
                            ->defaultValue(JwtCodecInterface::ALGORITHM_HS256)
                        ->end()
                        ->scalarNode('key')
                            ->defaultNull()
                        ->end()
                        ->scalarNode('passphrase')
                            ->defaultNull()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('credentials_extractor')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('type')
                            ->defaultValue('body_json')
                        ->end()
                        ->scalarNode('username_parameter')
                            ->defaultValue('username')
                        ->end()
                        ->scalarNode('password_parameter')
                            ->defaultValue('password')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('token')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('claims')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->arrayNode('issuer')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('name')
                                            ->defaultNull()
                                        ->end()
                                        ->scalarNode('value')
                                            ->defaultNull()
                                        ->end()
                                    ->end()
                                    ->beforeNormalization()
                                        ->always()
                                        ->then(function ($v) {
                                            if (is_string($v)) {
                                                $v = ['name' => ClaimInterface::CLAIM_NAME_ISS, 'value' => $v];
                                            } else {
                                                $v['name'] = ClaimInterface::CLAIM_NAME_ISS;
                                            }

                                            return $v;
                                        })
                                    ->end()
                                ->end()
                                ->arrayNode('subject')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('name')
                                            ->defaultNull()
                                        ->end()
                                        ->scalarNode('value')
                                            ->defaultNull()
                                        ->end()
                                    ->end()
                                    ->beforeNormalization()
                                        ->always()
                                        ->then(function ($v) {
                                            if (is_string($v)) {
                                                $v = ['name' => ClaimInterface::CLAIM_NAME_SUB, 'value' => $v];
                                            } else {
                                                $v['name'] = ClaimInterface::CLAIM_NAME_SUB;
                                            }

                                            return $v;
                                        })
                                    ->end()
                                ->end()
                                ->arrayNode('audience')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('name')
                                            ->defaultValue(ClaimInterface::CLAIM_NAME_AUD)
                                        ->end()
                                        ->scalarNode('value')
                                            ->defaultNull()
                                        ->end()
                                    ->end()
                                    ->beforeNormalization()
                                        ->always()
                                        ->then(function ($v) {
                                            if (is_string($v)) {
                                                $v = ['name' => ClaimInterface::CLAIM_NAME_AUD, 'value' => $v];
                                            } else {
                                                $v['name'] = ClaimInterface::CLAIM_NAME_AUD;
                                            }

                                            return $v;
                                        })
                                    ->end()
                                ->end()
                                ->arrayNode('user')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('name')
                                            ->defaultValue('[usr][username]')
                                        ->end()
                                        ->scalarNode('value')
                                            ->defaultValue('username')
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->scalarNode('ttl')
                            ->defaultValue(86400)
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
        return 'kpeu3i_jwt_creation';
    }
}