<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('DateRangePicker', template: '@UxBlocksLive/components/DateRangePicker.html.twig')]
final class DateRangePicker
{
    public ?string $start = null;

    public ?string $end = null;

    public ?string $name = null;

    public bool $disabled = false;

    public bool $invalid = false;

    public ?string $min = null;

    public ?string $max = null;

    public ?string $placeholderStart = null;

    public ?string $placeholderEnd = null;

    public ?string $format = null;
}
