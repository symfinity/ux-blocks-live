<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components\Collapsible;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Collapsible:Trigger', template: '@UxBlocksLive/components/Collapsible/Trigger.html.twig')]
final class Trigger
{
    public string $as = 'button';
}
