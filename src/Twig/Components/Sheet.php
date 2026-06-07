<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Sheet', template: '@UxBlocksLive/components/Sheet.html.twig')]
final class Sheet
{
    public string $side = 'right';
}

