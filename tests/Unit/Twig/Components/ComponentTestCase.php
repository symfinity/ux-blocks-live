<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests\Unit\Twig\Components;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\UX\TwigComponent\Test\InteractsWithTwigComponents;
use Symfinity\UxBlocksLive\Tests\Integration\UxBlocksLiveTestKernel;

abstract class ComponentTestCase extends KernelTestCase
{
    use InteractsWithTwigComponents;

    protected static function getKernelClass(): string
    {
        return UxBlocksLiveTestKernel::class;
    }

    /**
     * @param class-string|non-empty-string $name
     * @param array<string, mixed>          $data
     */
    protected function renderComponent(string $name, array $data = []): string
    {
        return (string) $this->renderTwigComponent($name, $data);
    }

    protected function assertRootAttributes(string $html, string $role, string $fragment): void
    {
        self::assertStringContainsString(sprintf('data-ui-role="%s"', $role), $html);
        self::assertStringContainsString(sprintf('data-ui-fragment="%s"', $fragment), $html);
        self::assertDoesNotMatchRegularExpression('/html_cva|tailwind_merge|twig-tailwind-extra/', $html);
    }
}
