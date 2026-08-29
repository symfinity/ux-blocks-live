<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests\Unit\Css;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class BlocksLiveCssTest extends TestCase
{
    private static function bundleCss(): string
    {
        $path = dirname(__DIR__, 3) . '/assets/styles/roles/_bundle.css';
        self::assertFileExists($path);

        return (string) file_get_contents($path);
    }

    #[Test]
    public function bundleIncludesLiveTierRootRoles(): void
    {
        $css = self::bundleCss();

        foreach (['combobox', 'combobox-content', 'combobox-item', 'tags-input'] as $role) {
            self::assertStringContainsString('[data-ui-role="' . $role . '"]', $css, $role);
        }
    }

    #[Test]
    public function comboboxItemHoverUsesElevatedSurface(): void
    {
        $css = self::bundleCss();

        self::assertStringContainsString('[data-ui-role="combobox-item"]:hover', $css);
        self::assertStringContainsString('var(--ui-color-surface-elevated)', $css);
    }
}
