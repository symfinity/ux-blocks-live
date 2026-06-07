<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('AlertDialog:Trigger', template: '@UxBlocksLive/components/AlertDialog/Trigger.html.twig')]
final class AlertDialogTrigger
{
}
