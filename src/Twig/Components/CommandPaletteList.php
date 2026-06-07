<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('CommandPalette:List', template: '@UxBlocksLive/components/CommandPalette/List.html.twig')]
final class CommandPaletteList
{
}
