<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests\Unit;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfinity\UxBlocks\Registry\LiveRoleCatalog;
use Symfony\Component\Yaml\Yaml;

final class RegistryConsistencyTest extends TestCase
{
    /** @return array<string, array{0: string}> */
    public static function liveRoleProvider(): array
    {
        $provider = [];
        foreach (LiveRoleCatalog::roles() as $role) {
            $provider[$role] = [$role];
        }

        return $provider;
    }

    #[Test]
    public function yamlSchemaVersionMatchesContract(): void
    {
        $registry = $this->loadRegistry();

        self::assertSame('1.4', $registry['ux_role_registry']);
        self::assertSame('blocks.live', $registry['registry_prefix']);
    }

    #[Test]
    public function yamlContainsAllLiveRoles(): void
    {
        $registry = $this->loadRegistry();
        $roles = array_column($registry['roles'], 'role');

        self::assertSame(LiveRoleCatalog::roles(), $roles);
    }

    #[Test]
    #[DataProvider('liveRoleProvider')]
    public function eachRowHasRequiredFields(string $role): void
    {
        $row = $this->findRole($role);

        self::assertSame($role, $row['role']);
        self::assertNotEmpty($row['twig_component']);
        self::assertNotEmpty($row['php_class']);
        self::assertSame('blocks.live.' . $role, $row['fragment_id']);
        self::assertSame('blocks.live.' . $role . '.{n}', $row['fragment_pattern']);
        self::assertSame('B', $row['stage']);
        self::assertSame('shipped', $row['status']);
        self::assertStringContainsString('Live', $row['twig_component']);
        self::assertTrue(class_exists($row['php_class']), $row['php_class']);
    }

    /** @return array<string, mixed> */
    private function loadRegistry(): array
    {
        return Yaml::parseFile(\dirname(__DIR__, 2) . '/config/ux_roles.yaml');
    }

    /** @return array<string, mixed> */
    private function findRole(string $role): array
    {
        foreach ($this->loadRegistry()['roles'] as $row) {
            if (($row['role'] ?? null) === $role) {
                return $row;
            }
        }

        self::fail(sprintf('Role "%s" not found in ux_roles.yaml', $role));
    }
}
