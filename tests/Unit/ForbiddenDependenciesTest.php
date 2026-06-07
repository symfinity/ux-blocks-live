<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

final class ForbiddenDependenciesTest extends TestCase
{
    private const FORBIDDEN = ['ux-toolkit', 'html_cva', 'tailwind_merge'];

    #[Test]
    public function packageSourceDoesNotReferenceForbiddenTooling(): void
    {
        $root = \dirname(__DIR__, 2);
        $paths = [
            $root . '/src',
            $root . '/assets',
            $root . '/templates',
            $root . '/composer.json',
        ];

        foreach ($paths as $path) {
            if (is_file($path)) {
                $this->assertFileDoesNotContainForbidden($path);

                continue;
            }

            if (!is_dir($path)) {
                continue;
            }

            $iterator = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
            );

            /** @var SplFileInfo $file */
            foreach ($iterator as $file) {
                if (!$file->isFile()) {
                    continue;
                }

                $name = $file->getFilename();
                if (str_ends_with($name, '.php') || str_ends_with($name, '.js') || str_ends_with($name, '.twig') || str_ends_with($name, '.json')) {
                    $this->assertFileDoesNotContainForbidden($file->getPathname());
                }
            }
        }
    }

    private function assertFileDoesNotContainForbidden(string $file): void
    {
        $contents = (string) file_get_contents($file);

        foreach (self::FORBIDDEN as $needle) {
            self::assertStringNotContainsString(
                $needle,
                $contents,
                sprintf('Forbidden reference "%s" in %s', $needle, $file),
            );
        }
    }
}
