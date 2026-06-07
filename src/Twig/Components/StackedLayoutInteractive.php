<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('StackedLayoutInteractive', template: '@UxBlocksLive/components/StackedLayoutInteractive.html.twig')]
final class StackedLayoutInteractive
{
    public string $defaultPanel = '';
}
