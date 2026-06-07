<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('CommandPalette:Input', template: '@UxBlocksLive/components/CommandPalette/Input.html.twig')]
final class CommandPaletteInput
{
}
