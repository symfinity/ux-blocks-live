<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('InputOtp', template: '@UxBlocksLive/components/InputOtp.html.twig')]
final class InputOtp
{
    public int $length = 6;

}
