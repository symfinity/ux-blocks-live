<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests\Unit\Css;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * 120 SC-003 — primary role selector inventory for coverage measurement.
 */
final class RoleSelectorInventoryTest extends TestCase
{
    /**
     * Literal selector inventory — scanned by {@see \Symfinity\UxBlocks\DevTools\CssSelectorCoverageReporter}.
     */
    private const SELECTOR_INVENTORY = <<<'SELECTORS'
[data-ui-role="combobox"]
[data-ui-role="combobox-content"]
[data-ui-role="combobox-item"]
[data-ui-role="data-table-chrome-interactive"]
[data-ui-role="date-picker"]
[data-ui-role="date-picker-content"]
[data-ui-role="date-range-picker"]
[data-ui-role="date-range-picker-content"]
[data-ui-role="date-range-picker-segment"]
[data-ui-role="date-range-picker-segments"]
[data-ui-role="tags-input"]
[data-ui-role="tags-input-chip"]
[data-ui-role="tags-input-field"]
SELECTORS;

    private static function bundleCss(): string
    {
        $path = dirname(__DIR__, 3) . '/assets/styles/roles/_bundle.css';
        self::assertFileExists($path);

        return (string) file_get_contents($path);
    }

    #[Test]
    public function bundleIncludesPrimaryRoleSelectors(): void
    {
        $css = self::bundleCss();

        foreach (self::inventoryRoles() as $role) {
            self::assertStringContainsString('[data-ui-role="' . $role . '"]', $css, $role);
        }
    }

    /**
     * @return list<string>
     */
    private static function inventoryRoles(): array
    {
        preg_match_all('/\[data-ui-role="([^"]+)"\]/', self::SELECTOR_INVENTORY, $matches);

        return $matches[1];
    }
}
