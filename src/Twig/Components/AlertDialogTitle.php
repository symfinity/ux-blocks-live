<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('AlertDialog:Title', template: '@UxBlocksLive/components/AlertDialog/Title.html.twig')]
final class AlertDialogTitle
{
}
