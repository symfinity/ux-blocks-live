<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests\Integration;

use Symfinity\UxBlocksCore\SymfinityUxBlocksCoreBundle;
use Symfinity\UxBlocksExtended\SymfinityUxBlocksExtendedBundle;
use Symfinity\UxBlocksInteractive\SymfinityUxBlocksInteractiveBundle;
use Symfinity\UxBlocksLive\SymfinityUxBlocksLiveBundle;
use Symfony\Bundle\FrameworkBundle\FrameworkBundle;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Symfony\UX\LiveComponent\LiveComponentBundle;
use Symfony\UX\StimulusBundle\StimulusBundle;
use Symfony\UX\Turbo\TurboBundle;
use Symfony\UX\TwigComponent\TwigComponentBundle;

final class UxBlocksLiveTestKernel extends Kernel
{
    use MicroKernelTrait;

    public function getProjectDir(): string
    {
        return \dirname(__DIR__, 2);
    }

    public function getCacheDir(): string
    {
        return $this->getProjectDir() . '/var/cache/' . $this->environment;
    }

    public function registerBundles(): array
    {
        return [
            new FrameworkBundle(),
            new TwigBundle(),
            new StimulusBundle(),
            new TwigComponentBundle(),
            new LiveComponentBundle(),
            new TurboBundle(),
            new SymfinityUxBlocksCoreBundle(),
            new SymfinityUxBlocksExtendedBundle(),
            new SymfinityUxBlocksInteractiveBundle(),
            new SymfinityUxBlocksLiveBundle(),
        ];
    }

    protected function configureRoutes(RoutingConfigurator $routes): void
    {
        // 107: tier catalog routes.yaml retired (Phase 2); only LiveComponent routes remain.
        $routes->import('@LiveComponentBundle/config/routes.php');
    }

    protected function configureContainer(ContainerConfigurator $container): void
    {
        $container->extension('framework', [
            'secret' => 'test-secret',
            'test' => true,
            'router' => ['utf8' => true],
            'php_errors' => ['log' => false],
        ]);

        // 107 Stage B opt-in: tier fragment tests assert the enabled path.
        $container->extension('symfinity_ux_blocks_core', [
            'fragment_ids' => true,
        ]);

        $container->extension('twig_component', [
            'anonymous_template_directory' => 'components',
            'defaults' => [
                'Symfinity\\UxBlocksCore\\Twig\\Components\\' => 'components',
                'Symfinity\\UxBlocksExtended\\Twig\\Components\\' => 'components',
                'Symfinity\\UxBlocksInteractive\\Twig\\Components\\' => 'components',
                'Symfinity\\UxBlocksLive\\Twig\\Components\\' => 'components',
            ],
        ]);

        $container->extension('twig', [
            'form_themes' => [],
        ]);

        $container->services()
            ->set('twig.extension.form', StubFormTwigExtension::class)
            ->tag('twig.extension')
            ->public();
    }
}
