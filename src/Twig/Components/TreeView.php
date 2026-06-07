<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('TreeView', template: '@UxBlocksLive/components/TreeView.html.twig')]
final class TreeView
{
    /** @var list<array{id: string, label: string, children?: list<mixed>, disabled?: bool}> */
    public array $nodes = [];

    /** @var list<string> */
    public array $expanded = [];

    public ?string $selected = null;

    public bool $selectable = false;

    public ?string $label = null;

    public ?string $lazyLoad = null;
}
