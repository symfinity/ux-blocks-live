<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests\Unit\Twig\Components;

use PHPUnit\Framework\Attributes\Test;

final class TabsTest extends ComponentTestCase
{
    #[Test]
    public function rootHasBlocksExtFragment(): void
    {
        self::bootKernel();
        $html = $this->renderComponent('Tabs', ['defaultValue' => 'a', 'orientation' => 'horizontal']);

        $this->assertRootAttributes($html, 'tabs', 'blocks.live.tabs');
        self::assertStringContainsString('data-controller="symfony--ux-blocks-live--tabs"', $html);
    }

    #[Test]
    public function triggerWiresSelectActionAndActiveState(): void
    {
        self::bootKernel();
        $html = $this->renderComponent('Tabs:Trigger', ['value' => 'a', 'active' => true]);

        self::assertStringContainsString('data-ui-role="tabs-trigger"', $html);
        self::assertStringContainsString('data-action="click->symfony--ux-blocks-live--tabs#select"', $html);
        self::assertStringContainsString('aria-selected="true"', $html);
    }

    #[Test]
    public function disabledTriggerExposesDisabledState(): void
    {
        self::bootKernel();
        $html = $this->renderComponent('Tabs:Trigger', ['value' => 'x', 'disabled' => true]);

        self::assertStringContainsString('disabled', $html);
        self::assertStringContainsString('data-ui-state="disabled"', $html);
    }

    #[Test]
    public function linkedTriggerRendersAnchor(): void
    {
        self::bootKernel();
        $html = $this->renderComponent('Tabs:Trigger', ['value' => 'docs', 'href' => '/docs']);

        self::assertStringContainsString('<a', $html);
        self::assertStringContainsString('href="/docs"', $html);
        self::assertStringContainsString('data-ui-state="linked"', $html);
        self::assertStringNotContainsString('data-action=', $html);
    }

    #[Test]
    public function contentHonoursActivePanelVisibility(): void
    {
        self::bootKernel();
        $active = $this->renderComponent('Tabs:Content', ['value' => 'a', 'active' => true]);
        $inactive = $this->renderComponent('Tabs:Content', ['value' => 'b']);

        self::assertStringNotContainsString(' hidden', $active);
        self::assertStringContainsString('aria-hidden="false"', $active);
        self::assertStringContainsString(' hidden', $inactive);
        self::assertStringContainsString('aria-hidden="true"', $inactive);
    }
}
