<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Sidebar', template: '@UxBlocksLive/components/Sidebar.html.twig')]
final class Sidebar
{
    public string $side = 'left';

}
