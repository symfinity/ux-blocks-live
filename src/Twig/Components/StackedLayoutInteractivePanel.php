<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('StackedLayoutInteractive:Panel', template: '@UxBlocksLive/components/StackedLayoutInteractive/Panel.html.twig')]
final class StackedLayoutInteractivePanel
{
    public string $panel = '';
}
