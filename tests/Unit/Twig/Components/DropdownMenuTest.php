<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests\Unit\Twig\Components;

use PHPUnit\Framework\Attributes\Test;

final class DropdownMenuTest extends ComponentTestCase
{
    #[Test]
    public function rootHasBlocksExtFragment(): void
    {
        self::bootKernel();
        $html = $this->renderComponent('DropdownMenu');

        $this->assertRootAttributes($html, 'dropdown-menu', 'blocks.live.dropdown-menu');
        self::assertStringContainsString('data-controller="symfony--ux-blocks-live--dropdown-menu"', $html);
    }
}
