<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Sidebar:Header', template: '@UxBlocksLive/components/Sidebar/Header.html.twig')]
final class SidebarHeader
{
}
