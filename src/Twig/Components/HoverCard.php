<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('HoverCard', template: '@UxBlocksLive/components/HoverCard.html.twig')]
final class HoverCard
{
    public int $openDelay = 200; public int $closeDelay = 100;
}

