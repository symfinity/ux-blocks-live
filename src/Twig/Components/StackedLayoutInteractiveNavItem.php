<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('StackedLayoutInteractive:NavItem', template: '@UxBlocksLive/components/StackedLayoutInteractive/NavItem.html.twig')]
final class StackedLayoutInteractiveNavItem
{
    public string $panel = '';
}
