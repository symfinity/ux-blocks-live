<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Menubar:Item', template: '@UxBlocksLive/components/Menubar/Item.html.twig')]
final class MenubarItem
{
    public bool $disabled = false;
}
