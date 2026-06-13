<?php

namespace Tgram\Config;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use function in_array;

class YamlConfiguration implements ConfigurationInterface
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

                ->arrayNode('allow_updates')
                    ->isRequired()
                    ->children()
                        ->booleanNode('message')
                        ->defaultTrue()
                        ->isRequired()
                        ->end()

                        ->booleanNode('edited_message')
                        ->defaultTrue()
                        ->isRequired()
                        ->end()
                        
                        ->booleanNode('channel_post')
                        ->defaultTrue()
                        ->isRequired()
                        ->end()

                        ->booleanNode('edited_channel_post')
                        ->defaultTrue()
                        ->isRequired()
                        ->end()

                        ->booleanNode('business_connection')
                        ->defaultTrue()
                        ->isRequired()
                        ->end()

                        ->booleanNode('business_message')
                        ->defaultTrue()
                        ->isRequired()
                        ->end()

                        ->booleanNode('edited_business_message')
                        ->defaultTrue()
                        ->isRequired()
                        ->end()
                        
                        ->booleanNode('deleted_business_messages')
                        ->defaultTrue()
                        ->isRequired()
                        ->end()

                        ->booleanNode('guest_message')
                        ->defaultTrue()
                        ->isRequired()
                        ->end()

                        ->booleanNode('message_reaction')
                        ->defaultTrue()
                        ->isRequired()
                        ->end()

                        ->booleanNode('message_reaction_count')
                        ->defaultTrue()
                        ->isRequired()
                        ->end()

                        ->booleanNode('inline_query')
                        ->defaultTrue()
                        ->isRequired()
                        ->end()

                        ->booleanNode('chosen_inline_result')
                        ->defaultTrue()
                        ->isRequired()
                        ->end()

                        ->booleanNode('callback_query')
                        ->defaultTrue()
                        ->isRequired()
                        ->end()

                        ->booleanNode('shipping_query')
                        ->defaultTrue()
                        ->isRequired()
                        ->end()

                        ->booleanNode('pre_checkout_query')
                        ->defaultTrue()
                        ->isRequired()
                        ->end()

                        ->booleanNode('purchased_paid_media')
                        ->defaultTrue()
                        ->isRequired()
                        ->end()

                        ->booleanNode('poll')
                        ->defaultTrue()
                        ->isRequired()
                        ->end()

                        ->booleanNode('poll_answer')
                        ->defaultTrue()
                        ->isRequired()
                        ->end()

                        ->booleanNode('my_chat_member')
                        ->defaultTrue()
                        ->isRequired()
                        ->end()

                        ->booleanNode('chat_member')
                        ->defaultTrue()
                        ->isRequired()
                        ->end()

                        ->booleanNode('chat_join_request')
                        ->defaultTrue()
                        ->isRequired()
                        ->end()

                        ->booleanNode('chat_boost')
                        ->defaultTrue()
                        ->isRequired()
                        ->end()

                        ->booleanNode('removed_chat_boost')
                        ->defaultTrue()
                        ->isRequired()
                        ->end()

                        ->booleanNode('managed_bot')
                        ->defaultTrue()
                        ->isRequired()
                        ->end()
                    ->end()
                ->end()

                ->arrayNode('proxy')
                    ->children()
                        ->booleanNode('enabled')
                            ->defaultFalse()
                        ->end()

                        ->scalarNode('host')
                        ->end()

                        ->integerNode('port')
                        ->end()
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }
}