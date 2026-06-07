<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests\Unit\Twig\Components;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;

final class NavigationComponentsTest extends ComponentTestCase
{
    /** @return array<string, array{0: string, 1: string, 2: string, 3: string, 4: array<string, mixed>}> */
    public static function navigationRoleProvider(): array
    {
        return [
            'menubar' => ['Menubar', 'menubar', 'blocks.live.menubar', 'menubar', []],
            'navigation-menu' => ['NavigationMenu', 'navigation-menu', 'blocks.live.navigation-menu', 'navigation-menu', []],
            'sidebar' => ['Sidebar', 'sidebar', 'blocks.live.sidebar', 'sidebar', ['side' => 'left']],
            'stacked-layout-interactive' => [
                'StackedLayoutInteractive',
                'stacked-layout-interactive',
                'blocks.live.stacked-layout-interactive',
                'stacked-layout-interactive',
                ['defaultPanel' => 'overview'],
            ],
        ];
    }

    #[Test]
    #[DataProvider('navigationRoleProvider')]
    public function rootHasBlocksExtFragment(
        string $component,
        string $role,
        string $fragment,
        string $controllerSlug,
        array $data,
    ): void {
        self::bootKernel();
        $html = $this->renderComponent($component, $data);

        $this->assertRootAttributes($html, $role, $fragment);
        self::assertStringContainsString(
            sprintf('data-controller="symfony--ux-blocks-live--%s"', $controllerSlug),
            $html,
        );
    }
}
