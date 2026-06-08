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
        $html = $this->renderLiveComponent('DatePickerLive');

        $this->assertRootAttributes($html, 'date-picker', 'blocks.live.date-picker');
        $this->assertStimulusController($html, 'symfony--ux-blocks-live--date-picker');
    }
}
