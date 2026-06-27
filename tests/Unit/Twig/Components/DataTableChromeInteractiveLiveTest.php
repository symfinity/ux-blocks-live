<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests\Unit\Twig\Components;

use PHPUnit\Framework\Attributes\Test;

final class DataTableChromeInteractiveLiveTest extends ComponentTestCase
{
    #[Test]
    public function rootHasBlocksLiveFragment(): void
    {
        self::bootKernel();
        $html = $this->renderLiveComponent('DataTableChromeInteractiveLive');

        $this->assertRootAttributes($html, 'data-table-chrome-interactive', 'blocks.live.data-table-chrome-interactive');
        $this->assertStimulusController($html, 'symfony--ux-blocks-live--data-table-chrome-interactive');
    }
}
