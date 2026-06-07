<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('TagsInput', template: '@UxBlocksLive/components/TagsInput.html.twig')]
final class TagsInput
{
    /** @var list<string|array{label: string, value?: string}> */
    public array $tags = [];

    public ?string $name = null;

    public ?string $placeholder = null;

    public bool $disabled = false;

    public bool $invalid = false;

    public ?int $maxTags = null;

    public bool $allowDuplicates = false;

    public string $delimiter = ',';
}
