<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests\Unit\Twig\Components;

use PHPUnit\Framework\Attributes\Test;

final class TagsInputLiveTest extends ComponentTestCase
{
    #[Test]
    public function rootHasBlocksLiveFragment(): void
    {
        self::bootKernel();
        $html = $this->renderLiveComponent('TagsInputLive');

        $this->assertRootAttributes($html, 'tags-input', 'blocks.live.tags-input');
        $this->assertStimulusController($html, 'symfony--ux-blocks-live--tags-input');
    }
}
