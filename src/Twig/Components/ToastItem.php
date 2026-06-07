<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Toast:Item', template: '@UxBlocksLive/components/Toast/Item.html.twig')]
final class ToastItem
{
}
