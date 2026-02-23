<?php

namespace Iwh3n\Tgram\Config;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use function in_array;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('tgram');

        /** @var ArrayNodeDefinition $rootNode */
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()

                ->arrayNode('bot')
                    ->isRequired()
                    ->children()

                        ->scalarNode('token')
                            ->isRequired()
                            ->cannotBeEmpty()
                        ->end()

                        ->scalarNode('entry_point')
                            ->isRequired()
                            ->cannotBeEmpty()
                            ->validate()
                                ->ifTrue(function ($value): bool {
                                    if (!filter_var($value, FILTER_VALIDATE_URL)) {
                                        return true;
                                    }

                                    $scheme = parse_url($value, PHP_URL_SCHEME);

                                    return !in_array($scheme, ['http', 'https']);
                                })
                                ->thenInvalid('Entry point must be a valid http or https URL.')
                            ->end()
                        ->end()

                    ->end()
                ->end()

            ->end();

        return $treeBuilder;
    }
}