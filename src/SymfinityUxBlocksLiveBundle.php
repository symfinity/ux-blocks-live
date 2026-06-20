<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive;

use Symfony\Bundle\TwigBundle\DependencyInjection\Configurator\TwigConfigurator;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class SymfinityUxBlocksLiveBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function configureRoutes(RoutingConfigurator $routes): void
    {
        // Stage A: no catalog routes — showroom in symfinity/ux-blocks-kiosk (107).
    }

    public function configureTwig(TwigConfigurator $configurator): void
    {
        $configurator->path($this->getPath() . '/templates', 'UxBlocksLive');
    }
}
