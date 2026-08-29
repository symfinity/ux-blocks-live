<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveAction;
use Symfony\UX\LiveComponent\Attribute\LiveArg;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('TagsInputLive', template: '@UxBlocksLive/components/TagsInput.html.twig')]
final class TagsInputLive
{
    use DefaultActionTrait;

    /** @var list<string|array{label: string, value?: string}> */
    #[LiveProp(writable: true)]
    public array $tags = [];

    #[LiveProp(writable: true)]
    public string $draft = '';

    #[LiveProp]
    public ?string $name = null;

    #[LiveProp]
    public ?string $placeholder = null;

    #[LiveProp]
    public bool $disabled = false;

    #[LiveProp]
    public bool $invalid = false;

    #[LiveProp]
    public ?int $maxTags = null;

    #[LiveProp]
    public bool $allowDuplicates = false;

    #[LiveProp]
    public string $delimiter = ',';

    #[LiveAction]
    public function addTag(#[LiveArg] ?string $label = null): void
    {
        if ($this->disabled) {
            return;
        }

        $label = trim($label ?? $this->draft);
        if ('' === $label) {
            return;
        }

        if (null !== $this->maxTags && \count($this->tags) >= $this->maxTags) {
            return;
        }

        if (!$this->allowDuplicates && $this->hasTagLabel($label)) {
            $this->draft = '';

            return;
        }

        $this->tags[] = $label;
        $this->draft = '';
    }

    #[LiveAction]
    public function removeTag(#[LiveArg] int $index): void
    {
        if ($this->disabled || !isset($this->tags[$index])) {
            return;
        }

        array_splice($this->tags, $index, 1);
    }

    #[LiveAction]
    public function removeLastTag(): void
    {
        if ($this->disabled || [] === $this->tags) {
            return;
        }

        array_pop($this->tags);
    }

    private function hasTagLabel(string $label): bool
    {
        foreach ($this->tags as $tag) {
            $tagLabel = \is_array($tag) ? (string) $tag['label'] : (string) $tag;
            if ($tagLabel === $label) {
                return true;
            }
        }

        return false;
    }
}
