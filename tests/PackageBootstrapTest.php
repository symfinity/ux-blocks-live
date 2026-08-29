<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests;

use PHPUnit\Framework\TestCase;
use Symfinity\UxBlocksLive\SymfinityUxBlocksLiveBundle;

final class PackageBootstrapTest extends TestCase
{
    public function testBundleClassExists(): void
    {
        self::assertTrue(class_exists(SymfinityUxBlocksLiveBundle::class));
    }
}
