<?php

declare(strict_types=1);

namespace Symfinity\UxBlocksLive\Tests\Integration;

use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\HttpClient\MockHttpClient;
use Symfony\Component\HttpClient\Response\MockResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\UX\TwigComponent\Test\InteractsWithTwigComponents;

final class CommandPaletteIntegrationTest extends KernelTestCase
{
    use InteractsWithTwigComponents;

    protected static function getKernelClass(): string
    {
        return UxBlocksLiveTestKernel::class;
    }

    #[Test]
    public function commandPaletteRendersWithCommandsUrlValue(): void
    {
        self::bootKernel();
        $html = (string) $this->renderTwigComponent('CommandPalette', [
            'commandsUrl' => '/_ui/palette/commands',
            'placeholder' => 'Search…',
        ]);

        self::assertStringContainsString('data-ui-fragment="blocks.live.command-palette"', $html);
        self::assertStringContainsString(
            'data-symfony--ux-blocks-live--command-palette-commands-url-value="/_ui/palette/commands"',
            $html,
        );
    }

    #[Test]
    public function paletteCommandsJsonMatchesRuntimeV1Shape(): void
    {
        $payload = json_encode([
            'version' => 1,
            'commands' => [
                [
                    'id' => 'demo.dashboard',
                    'title' => 'Dashboard',
                    'category' => 'Navigation',
                    'keywords' => ['home'],
                    'handler' => ['type' => 'url', 'url' => '/admin', 'turbo' => true],
                    'priority' => 10,
                ],
            ],
        ], \JSON_THROW_ON_ERROR);

        $client = new MockHttpClient([
            new MockResponse($payload, ['http_code' => Response::HTTP_OK]),
        ]);

        $response = $client->request('GET', '/_ui/palette/commands');
        self::assertSame(Response::HTTP_OK, $response->getStatusCode());

        /** @var array{version: int, commands: list<array<string, mixed>>} $decoded */
        $decoded = json_decode($response->getContent(), true, 512, \JSON_THROW_ON_ERROR);
        self::assertSame(1, $decoded['version']);
        self::assertArrayHasKey('id', $decoded['commands'][0]);
        self::assertArrayHasKey('title', $decoded['commands'][0]);
        self::assertArrayHasKey('handler', $decoded['commands'][0]);
    }
}
