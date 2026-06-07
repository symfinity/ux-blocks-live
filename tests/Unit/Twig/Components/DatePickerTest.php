<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests\Unit\Twig\Components;

use PHPUnit\Framework\Attributes\Test;

final class DatePickerTest extends ComponentTestCase
{
    #[Test]
    public function rootHasBlocksExtFragment(): void
    {
        self::bootKernel();
        $html = $this->renderComponent('DatePicker');

        $this->assertRootAttributes($html, 'date-picker', 'blocks.live.date-picker');
        self::assertStringContainsString('data-controller="symfony--ux-blocks-live--date-picker"', $html);
    }
}
