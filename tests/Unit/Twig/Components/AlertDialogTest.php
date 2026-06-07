<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests\Unit\Twig\Components;

use PHPUnit\Framework\Attributes\Test;

final class AlertDialogTest extends ComponentTestCase
{
    #[Test]
    public function rootHasBlocksExtFragment(): void
    {
        self::bootKernel();
        $html = $this->renderComponent('AlertDialog');

        $this->assertRootAttributes($html, 'alert-dialog-enhanced', 'blocks.live.alert-dialog-enhanced');
        self::assertStringContainsString('data-controller="symfony--ux-blocks-live--alert-dialog"', $html);
    }

    #[Test]
    public function contentHasAlertDialogAria(): void
    {
        self::bootKernel();
        $html = $this->renderComponent('AlertDialog:Content');

        self::assertStringContainsString('role="alertdialog"', $html);
        self::assertStringContainsString('aria-modal="true"', $html);
        self::assertStringContainsString('data-ui-role="alert-dialog-content"', $html);
    }

    #[Test]
    public function triggerExposesDialogPopupSemantics(): void
    {
        self::bootKernel();
        $html = $this->renderComponent('AlertDialog:Trigger');

        self::assertStringContainsString('aria-haspopup="dialog"', $html);
        self::assertStringContainsString('aria-expanded="false"', $html);
        self::assertStringContainsString('data-ui-role="alert-dialog-trigger"', $html);
    }

    #[Test]
    public function titleAndDescriptionRolesPresent(): void
    {
        self::bootKernel();
        $title = $this->renderComponent('AlertDialog:Title');
        $description = $this->renderComponent('AlertDialog:Description');

        self::assertStringContainsString('data-ui-role="alert-dialog-title"', $title);
        self::assertStringContainsString('data-ui-role="alert-dialog-description"', $description);
    }
}
