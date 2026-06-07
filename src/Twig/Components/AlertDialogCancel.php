<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('AlertDialog:Cancel', template: '@UxBlocksLive/components/AlertDialog/Cancel.html.twig')]
final class AlertDialogCancel
{
}
