<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests\Unit\Twig\Components;

use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\UX\TwigComponent\Test\InteractsWithTwigComponents;
use Symfinity\UxBlocksLive\Tests\Integration\UxBlocksLiveMarketingCompositionTestKernel;

final class FlyoutMenuMarketingEnhancedTest extends KernelTestCase
{
    use InteractsWithTwigComponents;

    protected static function getKernelClass(): string
    {
        return UxBlocksLiveMarketingCompositionTestKernel::class;
    }

    #[Test]
    public function enhancedFlyoutComposesInteractiveDropdownWhenLiveTierPresent(): void
    {
        self::bootKernel();
        $html = (string) $this->renderTwigComponent('FlyoutMenuMarketing', [
            'enhanced' => true,
            'items' => [['label' => 'Docs', 'href' => '/docs']],
        ]);

        self::assertStringContainsString('data-ui-role="flyout-menu-marketing"', $html);
        self::assertStringContainsString('data-controller="symfinity--ux-blocks-interactive--dropdown-menu"', $html);
    }
}
