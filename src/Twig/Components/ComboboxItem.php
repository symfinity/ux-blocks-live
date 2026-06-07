<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Combobox:Item', template: '@UxBlocksLive/components/Combobox/Item.html.twig')]
final class ComboboxItem
{
}
