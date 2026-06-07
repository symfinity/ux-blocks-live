<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Drawer', template: '@UxBlocksLive/components/Drawer.html.twig')]
final class Drawer
{
    public string $side = 'bottom';
}

