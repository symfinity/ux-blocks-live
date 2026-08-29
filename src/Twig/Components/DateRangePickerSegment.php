<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('DateRangePicker:Segment', template: '@UxBlocksLive/components/DateRangePicker/Segment.html.twig')]
final class DateRangePickerSegment
{
    public string $segment = 'start';

    public ?string $value = null;

    public ?string $placeholder = null;

    public ?string $label = null;

    public bool $disabled = false;

    public bool $invalid = false;
}
