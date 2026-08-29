<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('ComboboxLive', template: '@UxBlocksLive/components/Combobox.html.twig')]
final class ComboboxLive
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public ?string $selected = null;

    #[LiveProp]
    public bool $creatable = false;

    #[LiveProp]
    public ?string $onCreateValue = null;

    #[LiveProp]
    public bool $preventDuplicates = true;
}
