<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('CommandPalette', template: '@UxBlocksLive/components/CommandPalette.html.twig')]
final class CommandPalette
{
    public string $commandsUrl = '';

    public string $placeholder = 'Search…';

    public string $openHotkey = 'k';

    /** @var list<array<string, mixed>> */
    public array $fallbackCommands = [];
}
