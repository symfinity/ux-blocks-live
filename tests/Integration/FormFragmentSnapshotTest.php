<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests\Integration;

use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Twig\Environment;

final class FormFragmentSnapshotTest extends KernelTestCase
{
    #[Test]
    public function comboboxFixtureHasListboxFilterAndOptions(): void
    {
        self::bootKernel();
        $html = $this->renderFixture(<<<'TWIG'
<twig:Combobox>
    <twig:Combobox:Trigger>Select</twig:Combobox:Trigger>
    <twig:Combobox:Content>
        <twig:Combobox:Item data-value="a">Alpha</twig:Combobox:Item>
        <twig:Combobox:Item data-value="b">Beta</twig:Combobox:Item>
    </twig:Combobox:Content>
</twig:Combobox>
TWIG);

        self::assertStringContainsString('data-ui-fragment="blocks.live.combobox"', $html);
        self::assertStringContainsString('role="listbox"', $html);
        self::assertStringContainsString('role="option"', $html);
        self::assertStringContainsString('combobox#filter', $html);
        self::assertStringContainsString('combobox#selectItem', $html);
    }

    #[Test]
    public function datePickerFixtureOpensCalendarContent(): void
    {
        self::bootKernel();
        $html = $this->renderFixture(<<<'TWIG'
<twig:DatePicker>
    <twig:DatePicker:Trigger />
    <twig:DatePicker:Content>
        <twig:Calendar />
    </twig:DatePicker:Content>
</twig:DatePicker>
TWIG);

        self::assertStringContainsString('data-ui-fragment="blocks.live.date-picker"', $html);
        self::assertStringContainsString('data-ui-fragment="blocks.live.calendar"', $html);
        self::assertStringContainsString('date-picker#toggle', $html);
        self::assertStringContainsString('role="dialog"', $html);
        self::assertStringContainsString('hidden', $html);
    }

    private function renderFixture(string $template): string
    {
        /** @var Environment $twig */
        $twig = static::getContainer()->get(Environment::class);

        return (string) $twig->createTemplate($template)->render();
    }

    protected static function getKernelClass(): string
    {
        return UxBlocksLiveTestKernel::class;
    }
}
