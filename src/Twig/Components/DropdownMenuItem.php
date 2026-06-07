<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('DropdownMenu:Item', template: '@UxBlocksLive/components/DropdownMenu/Item.html.twig')]
final class DropdownMenuItem
{
    public bool $disabled = false;
}
