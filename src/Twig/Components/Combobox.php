<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Combobox', template: '@UxBlocksLive/components/Combobox.html.twig')]
final class Combobox
{
    public bool $creatable = false;

    public ?string $onCreateValue = null;

    public bool $preventDuplicates = true;
}
