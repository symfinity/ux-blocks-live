<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

final class StimulusControllersTest extends TestCase
{
    /** @return array<string, array{0: string}> */
    public static function liveControllerProvider(): array
    {
        return [
            'combobox' => ['combobox'],
            'date-picker' => ['date-picker'],
            'date-range-picker' => ['date-range-picker'],
            'tags-input' => ['tags-input'],
            'data-table-chrome-interactive' => ['data-table-chrome-interactive'],
        ];
    }

    #[Test]
    #[DataProvider('liveControllerProvider')]
    public function liveTierControllerAssetExists(string $slug): void
    {
        $path = \dirname(__DIR__, 2) . '/assets/controllers/' . $slug . '_controller.js';

        self::assertFileExists($path, sprintf('Missing Stimulus controller for live role "%s"', $slug));
        self::assertNotSame('', trim((string) file_get_contents($path)));
    }

    #[Test]
    public function packageJsonRegistersComboboxController(): void
    {
        $path = \dirname(__DIR__, 2) . '/assets/package.json';
        self::assertFileExists($path);

        $package = json_decode((string) file_get_contents($path), true);
        self::assertIsArray($package);
        self::assertSame('@symfinity/ux-blocks-live', $package['name'] ?? null);
        self::assertSame(
            'controllers/combobox_controller.js',
            $package['symfony']['controllers']['combobox']['main'] ?? null,
        );
    }

    #[Test]
    public function packageJsonRegistersOnlyExistingControllerAssets(): void
    {
        $root = \dirname(__DIR__, 2);
        $package = json_decode((string) file_get_contents($root . '/assets/package.json'), true);
        self::assertIsArray($package);

        foreach (array_keys($package['symfony']['controllers'] ?? []) as $slug) {
            self::assertFileExists(
                $root . '/assets/controllers/' . $slug . '_controller.js',
                sprintf('package.json registers missing controller "%s"', $slug),
            );
        }
    }
}
