<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Tabs', template: '@UxBlocksLive/components/Tabs.html.twig')]
final class Tabs
{
    public string $orientation = 'horizontal';

    public string $defaultValue = '';
}
