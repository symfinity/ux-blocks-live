<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class SymfinityUxBlocksLiveExtension extends Extension implements PrependExtensionInterface
{
    public function prepend(ContainerBuilder $container): void
    {
        if ($container->hasExtension('framework')) {
            $container->prependExtensionConfig('framework', [
                'asset_mapper' => [
                    'paths' => [
                        \dirname(__DIR__, 2).'/assets' => 'ux-blocks-live',
                    ],
                ],
            ]);
        }

        $container->prependExtensionConfig('twig', [
            'paths' => [
                \dirname(__DIR__, 2) . '/templates' => 'UxBlocksLive',
            ],
        ]);

        $container->prependExtensionConfig('twig_component', [
            'defaults' => [
                'Symfinity\\UxBlocksLive\\Twig\\Components\\' => [
                    'template_directory' => 'components',
                ],
            ],
        ]);
    }

    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(\dirname(__DIR__, 2) . '/config'));
        $loader->load('services.yaml');
    }
}
