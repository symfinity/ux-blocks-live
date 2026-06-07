<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Resizable:Panel', template: '@UxBlocksLive/components/Resizable/Panel.html.twig')]
final class ResizablePanel
{
}
