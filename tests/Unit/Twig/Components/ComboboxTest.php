<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests\Unit\Twig\Components;

use PHPUnit\Framework\Attributes\Test;
use Symfony\UX\TwigComponent\Test\InteractsWithTwigComponents;

final class ComboboxTest extends ComponentTestCase
{
    use InteractsWithTwigComponents;

    #[Test]
    public function rootHasBlocksExtFragment(): void
    {
        self::bootKernel();
        $html = $this->renderLiveComponent('ComboboxLive');

        $this->assertRootAttributes($html, 'combobox', 'blocks.live.combobox');
        $this->assertStimulusController($html, 'symfinity--ux-blocks-live--combobox');
    }

    #[Test]
    public function liveComboboxCarriesASelectedModelInput(): void
    {
        self::bootKernel();
        $html = $this->renderLiveComponent('ComboboxLive', ['selected' => 'b']);

        self::assertMatchesRegularExpression(
            '/<input\b(?=[^>]*\btype="hidden")(?=[^>]*\bdata-model="selected")(?=[^>]*\bvalue="b")(?=[^>]*\bdata-symfinity--ux-blocks-live--combobox-target="model")[^>]*>/',
            $html,
        );
        self::assertSame(1, preg_match_all('/\bdata-controller="/', $this->rootTag($html)), 'root has one data-controller attribute');
        self::assertMatchesRegularExpression('/data-controller="(?:[^"]*\s)?live[\s"]/', $html);
    }

    #[Test]
    public function liveComboboxNameGoesOnTheModelInput(): void
    {
        self::bootKernel();
        $html = $this->renderLiveComponent('ComboboxLive', ['name' => 'country']);

        self::assertMatchesRegularExpression('/<input\b(?=[^>]*\bdata-model="selected")(?=[^>]*\bname="country")[^>]*>/', $html);
        self::assertStringNotContainsString('name="country"', $this->rootTag($html));
    }

    #[Test]
    public function itemMergesCallerActionsIntoOneAttribute(): void
    {
        self::bootKernel();
        $html = (string) $this->renderTwigComponent('Combobox:Item', ['data-action' => 'click->live#action']);

        self::assertSame(1, preg_match_all('/\bdata-action="/', $html), 'one data-action attribute');
        self::assertMatchesRegularExpression(
            '/data-action="click-(?:>|&gt;)symfinity--ux-blocks-live--combobox#selectItem click-(?:>|&gt;)live#action"/',
            $html,
        );
    }

    #[Test]
    public function plainComboboxHasNoModelInput(): void
    {
        self::bootKernel();
        $html = (string) $this->renderTwigComponent('Combobox');

        self::assertStringNotContainsString('data-model=', $html);
        self::assertDoesNotMatchRegularExpression('/data-controller="(?:[^"]*\s)?live[\s"]/', $html);
        $this->assertStimulusController($html, 'symfinity--ux-blocks-live--combobox');
    }

    private function rootTag(string $html): string
    {
        return preg_match('/<div\b[^>]*>/', $html, $m) === 1 ? $m[0] : '';
    }
}
