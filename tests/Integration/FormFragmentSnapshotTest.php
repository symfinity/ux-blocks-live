<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests\Integration;

use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\UX\LiveComponent\Test\InteractsWithLiveComponents;

final class FormFragmentSnapshotTest extends KernelTestCase
{
    use InteractsWithLiveComponents;

    #[Test]
    public function comboboxLiveFixtureRendersRootFragment(): void
    {
        self::bootKernel();
        $html = (string) $this->createLiveComponent('ComboboxLive')->render();

        self::assertStringContainsString('data-ui-fragment="blocks.live.combobox"', $html);
        self::assertStringContainsString('data-ui-role="combobox"', $html);
    }

    #[Test]
    public function datePickerLiveFixtureRendersRootFragment(): void
    {
        self::bootKernel();
        $html = (string) $this->createLiveComponent('DatePickerLive')->render();

        self::assertStringContainsString('data-ui-fragment="blocks.live.date-picker"', $html);
        self::assertStringContainsString('data-ui-role="date-picker"', $html);
    }

    protected static function getKernelClass(): string
    {
        return UxBlocksLiveTestKernel::class;
    }
}
