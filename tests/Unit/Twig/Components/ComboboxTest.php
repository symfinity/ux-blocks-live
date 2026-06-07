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
        $html = $this->renderComponent('Combobox');

        $this->assertRootAttributes($html, 'combobox', 'blocks.live.combobox');
        self::assertStringContainsString('data-controller="symfony--ux-blocks-live--combobox"', $html);
    }
}
