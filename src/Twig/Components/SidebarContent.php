<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Sidebar:Content', template: '@UxBlocksLive/components/Sidebar/Content.html.twig')]
final class SidebarContent
{
}
