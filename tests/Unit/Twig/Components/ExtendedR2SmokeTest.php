<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests\Unit\Twig\Components;

use PHPUnit\Framework\Attributes\Test;

final class ExtendedR2SmokeTest extends ComponentTestCase
{
    #[Test]
    public function dateRangePickerHasBlocksExtFragment(): void
    {
        self::bootKernel();
        $html = $this->renderComponent('DateRangePicker');

        $this->assertRootAttributes($html, 'date-range-picker', 'blocks.live.date-range-picker');
        self::assertStringContainsString('data-controller="symfony--ux-blocks-live--date-range-picker"', $html);
    }

    #[Test]
    public function dateRangePickerSegmentsAreLabeled(): void
    {
        self::bootKernel();
        $html = $this->renderComponent('DateRangePicker');

        self::assertStringContainsString('aria-label="Start date"', $html);
        self::assertStringContainsString('aria-label="End date"', $html);
        self::assertStringContainsString('data-ui-role="date-range-picker-segment"', $html);
    }

    #[Test]
    public function tagsInputHasBlocksExtFragment(): void
    {
        self::bootKernel();
        $html = $this->renderComponent('TagsInput', ['tags' => ['php', 'symfony']]);

        $this->assertRootAttributes($html, 'tags-input', 'blocks.live.tags-input');
        self::assertStringContainsString('data-ui-role="tags-input-chip"', $html);
    }

    #[Test]
    public function tagsInputRendersChipRoots(): void
    {
        self::bootKernel();
        $html = $this->renderComponent('TagsInput', ['tags' => [['label' => 'Design']]]);

        self::assertStringContainsString('data-ui-role="tags-input-chip"', $html);
        self::assertStringContainsString('Design', $html);
    }

    #[Test]
    public function treeViewHasBlocksExtFragment(): void
    {
        self::bootKernel();
        $html = $this->renderComponent('TreeView', [
            'nodes' => [
                ['id' => 'root', 'label' => 'Root', 'children' => [
                    ['id' => 'child', 'label' => 'Child'],
                ]],
            ],
            'expanded' => ['root'],
        ]);

        $this->assertRootAttributes($html, 'tree-view', 'blocks.live.tree-view');
        self::assertStringContainsString('role="treeitem"', $html);
    }

    #[Test]
    public function comboboxDefaultMarkupRegression(): void
    {
        self::bootKernel();
        $html = $this->renderComponent('Combobox', ['creatable' => false]);

        $this->assertRootAttributes($html, 'combobox', 'blocks.live.combobox');
        self::assertStringContainsString('data-symfony--ux-blocks-live--combobox-creatable-value="false"', $html);
    }

    #[Test]
    public function comboboxCreatableExposesStimulusValue(): void
    {
        self::bootKernel();
        $html = $this->renderComponent('Combobox', ['creatable' => true]);

        self::assertStringContainsString('data-symfony--ux-blocks-live--combobox-creatable-value="true"', $html);
    }

    #[Test]
    public function comboboxOpenStateAriaAttributes(): void
    {
        self::bootKernel();
        $html = $this->renderComponent('Combobox:Trigger');

        self::assertStringContainsString('aria-expanded="false"', $html);
        self::assertStringContainsString('role="combobox"', $html);
    }

    #[Test]
    public function comboboxListboxContentAttributes(): void
    {
        self::bootKernel();
        $html = $this->renderComponent('Combobox:Content');

        self::assertStringContainsString('role="listbox"', $html);
    }

    #[Test]
    public function datePickerTriggerHasLabelingAttributes(): void
    {
        self::bootKernel();
        $html = $this->renderComponent('DatePicker:Trigger');

        self::assertStringContainsString('aria-haspopup="dialog"', $html);
        self::assertStringContainsString('aria-expanded="false"', $html);
    }
}
