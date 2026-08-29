<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class ComposerBoundaryTest extends TestCase
{
    #[Test]
    public function doesNotRequireUxRuntime(): void
    {
        /** @var array{require?: array<string, string>, suggest?: array<string, string>} $composer */
        $composer = json_decode(
            (string) file_get_contents(\dirname(__DIR__, 2) . '/composer.json'),
            true,
            512,
            \JSON_THROW_ON_ERROR,
        );

        self::assertArrayNotHasKey('symfinity/ux-runtime', $composer['require'] ?? []);
        self::assertArrayNotHasKey('symfinity/ux-runtime', $composer['suggest'] ?? []);
    }

    #[Test]
    public function requiresLiveComponentAndTurbo(): void
    {
        /** @var array{require?: array<string, string>} $composer */
        $composer = json_decode(
            (string) file_get_contents(\dirname(__DIR__, 2) . '/composer.json'),
            true,
            512,
            \JSON_THROW_ON_ERROR,
        );

        self::assertArrayHasKey('symfony/ux-live-component', $composer['require'] ?? []);
        self::assertArrayHasKey('symfony/ux-turbo', $composer['require'] ?? []);
    }
}
