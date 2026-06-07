<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('NavigationMenu:Item', template: '@UxBlocksLive/components/NavigationMenu/Item.html.twig')]
final class NavigationMenuItem
{
    public string $href = '#';
}
