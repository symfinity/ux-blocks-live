<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests\Integration;

use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\UX\LiveComponent\Test\InteractsWithLiveComponents;
use Symfinity\UxBlocksInteractive\SymfinityUxBlocksInteractiveBundle;
use Symfinity\UxBlocksLive\SymfinityUxBlocksLiveBundle;

final class BundleRegistrationTest extends KernelTestCase
{
    use InteractsWithLiveComponents;

    protected static function getKernelClass(): string
    {
        return UxBlocksLiveTestKernel::class;
    }

    #[Test]
    public function liveTestKernelRegistersInteractiveAndLiveBundles(): void
    {
        self::bootKernel();
        $bundleClasses = array_map(static fn (object $bundle): string => $bundle::class, static::$kernel->getBundles());

        self::assertContains(SymfinityUxBlocksInteractiveBundle::class, $bundleClasses);
        self::assertContains(SymfinityUxBlocksLiveBundle::class, $bundleClasses);
    }

    #[Test]
    public function comboboxLiveComponentRenders(): void
    {
        self::bootKernel();
        $test = $this->createLiveComponent('ComboboxLive');
        $html = (string) $test->render();

        self::assertStringContainsString('data-ui-fragment="blocks.live.combobox"', $html);
        self::assertStringContainsString('data-ui-role="combobox"', $html);
    }
}
