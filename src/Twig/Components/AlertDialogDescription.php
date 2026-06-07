<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('AlertDialog:Description', template: '@UxBlocksLive/components/AlertDialog/Description.html.twig')]
final class AlertDialogDescription
{
}
