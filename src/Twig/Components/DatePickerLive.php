<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('DatePickerLive', template: '@UxBlocksLive/components/DatePicker.html.twig')]
final class DatePickerLive
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public ?string $selected = null;
}
