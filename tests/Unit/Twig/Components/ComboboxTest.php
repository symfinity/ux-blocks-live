<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests\Unit\Twig\Components;

use PHPUnit\Framework\Attributes\Test;

final class ComboboxTest extends ComponentTestCase
{
    #[Test]
    public function rootHasBlocksExtFragment(): void
    {
        self::bootKernel();
        $html = $this->renderLiveComponent('ComboboxLive');

        $this->assertRootAttributes($html, 'combobox', 'blocks.live.combobox');
        $this->assertStimulusController($html, 'symfony--ux-blocks-live--combobox');
    }
}
