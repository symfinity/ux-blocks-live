<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Tabs:List', template: '@UxBlocksLive/components/Tabs/List.html.twig')]
final class TabsList
{
    public string $orientation = 'horizontal';
}
