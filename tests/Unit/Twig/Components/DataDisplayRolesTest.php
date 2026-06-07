<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests\Unit\Twig\Components;

use PHPUnit\Framework\Attributes\Test;

final class DataDisplayRolesTest extends ComponentTestCase
{
    #[Test]
    public function dataTableChromeInteractiveRootFragment(): void
    {
        self::bootKernel();
        $html = $this->renderComponent('DataTableChromeInteractive');

        $this->assertRootAttributes($html, 'data-table-chrome-interactive', 'blocks.live.data-table-chrome-interactive');
        self::assertStringContainsString('data-controller="symfony--ux-blocks-live--data-table-chrome-interactive"', $html);
    }

    #[Test]
    public function carouselInteractiveIncludesViewportAndControls(): void
    {
        self::bootKernel();
        $html = $this->renderComponent('CarouselInteractive');

        $this->assertRootAttributes($html, 'carousel-interactive', 'blocks.live.carousel-interactive');
        self::assertStringContainsString('carousel-interactive-viewport', $html);
        self::assertStringContainsString('carousel-interactive#prev', $html);
        self::assertStringContainsString('carousel-interactive#next', $html);
    }

    #[Test]
    public function resizableRootFragment(): void
    {
        self::bootKernel();
        $html = $this->renderComponent('Resizable');

        $this->assertRootAttributes($html, 'resizable', 'blocks.live.resizable');
        self::assertStringContainsString('data-controller="symfony--ux-blocks-live--resizable"', $html);
    }

    #[Test]
    public function toastRootFragment(): void
    {
        self::bootKernel();
        $html = $this->renderComponent('Toast');

        $this->assertRootAttributes($html, 'toast', 'blocks.live.toast');
        self::assertStringContainsString('aria-live="polite"', $html);
    }
}
