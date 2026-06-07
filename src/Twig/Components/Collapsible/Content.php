<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components\Collapsible;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Collapsible:Content', template: '@UxBlocksLive/components/Collapsible/Content.html.twig')]
final class Content
{
    public bool $forceMount = false;
}
