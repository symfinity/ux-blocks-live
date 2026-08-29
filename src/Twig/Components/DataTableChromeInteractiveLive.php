<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Twig\Components;

use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\DefaultActionTrait;

#[AsLiveComponent('DataTableChromeInteractiveLive', template: '@UxBlocksLive/components/DataTableChromeInteractive.html.twig')]
final class DataTableChromeInteractiveLive
{
    use DefaultActionTrait;

    #[LiveProp(writable: true)]
    public string $sort = '';

    #[LiveProp(writable: true)]
    public string $filter = '';

    #[LiveProp(writable: true)]
    public int $page = 1;
}
