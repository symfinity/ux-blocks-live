<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('Tabs:Content', template: '@UxBlocksLive/components/Tabs/Content.html.twig')]
final class TabsContent
{
    public string $value = '';

    /** Matches Tabs defaultValue for SSR visibility before Stimulus connects. */
    public bool $active = false;
}
