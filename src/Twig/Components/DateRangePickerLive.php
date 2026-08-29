<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('DateRangePickerLive', template: '@UxBlocksLive/components/DateRangePicker.html.twig')]
final class DateRangePickerLive
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public ?string $start = null;

    #[LiveProp(writable: true)]
    public ?string $end = null;

    #[LiveProp]
    public ?string $placeholderStart = null;

    #[LiveProp]
    public ?string $placeholderEnd = null;

    #[LiveProp]
    public bool $disabled = false;

    #[LiveProp]
    public bool $invalid = false;
}
