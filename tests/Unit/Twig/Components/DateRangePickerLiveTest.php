<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests\Unit\Twig\Components;

use PHPUnit\Framework\Attributes\Test;

final class DateRangePickerLiveTest extends ComponentTestCase
{
    #[Test]
    public function rootHasBlocksLiveFragment(): void
    {
        self::bootKernel();
        $html = $this->renderLiveComponent('DateRangePickerLive');

        $this->assertRootAttributes($html, 'date-range-picker', 'blocks.live.date-range-picker');
        $this->assertStimulusController($html, 'symfony--ux-blocks-live--date-range-picker');
    }
}
