<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests\Unit\Twig\Components;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\UX\LiveComponent\Test\InteractsWithLiveComponents;
use Symfinity\UxBlocksLive\Tests\Integration\UxBlocksLiveTestKernel;

abstract class ComponentTestCase extends KernelTestCase
{
    use InteractsWithLiveComponents;

    protected static function getKernelClass(): string
    {
        return UxBlocksLiveTestKernel::class;
    }

    /**
     * @param array<string, mixed> $data
     */
    protected function renderLiveComponent(string $name, array $data = []): string
    {
        return (string) $this->createLiveComponent($name, $data)->render();
    }

    protected function assertRootAttributes(string $html, string $role, string $fragment): void
    {
        self::assertStringContainsString(sprintf('data-ui-role="%s"', $role), $html);
        self::assertStringContainsString(sprintf('data-ui-fragment="%s"', $fragment), $html);
        self::assertDoesNotMatchRegularExpression('/html_cva|tailwind_merge|twig-tailwind-extra/', $html);
    }

    protected function assertStimulusController(string $html, string $controllerIdentifier): void
    {
        self::assertMatchesRegularExpression(
            sprintf('/\bdata-controller="[^"]*\b%s\b/', preg_quote($controllerIdentifier, '/')),
            $html,
        );
    }
}
