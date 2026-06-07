<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Sidebar:Title', template: '@UxBlocksLive/components/Sidebar/Title.html.twig')]
final class SidebarTitle
{
}
