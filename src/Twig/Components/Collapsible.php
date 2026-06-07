<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;
use Symfony\UX\TwigComponent\Attribute\ExposeInTemplate;

#[AsTwigComponent('Collapsible', template: '@UxBlocksLive/components/Collapsible.html.twig')]
final class Collapsible
{
    public bool $defaultOpen = false;

    public ?bool $open = null;

    public bool $disabled = false;

    private string $generatedContentId = '';

    public function mount(): void
    {
        if ($this->generatedContentId === '') {
            $this->generatedContentId = 'collapsible-content-' . bin2hex(random_bytes(4));
        }
    }

    #[ExposeInTemplate('collapsible_is_open')]
    public function isOpen(): bool
    {
        return $this->open ?? $this->defaultOpen;
    }

    #[ExposeInTemplate('collapsible_content_id')]
    public function contentId(): string
    {
        return $this->generatedContentId;
    }

    #[ExposeInTemplate('collapsible_disabled')]
    public function isDisabled(): bool
    {
        return $this->disabled;
    }
}
