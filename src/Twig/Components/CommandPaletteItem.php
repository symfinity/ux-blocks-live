<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('CommandPalette:Item', template: '@UxBlocksLive/components/CommandPalette/Item.html.twig')]
final class CommandPaletteItem
{
}
