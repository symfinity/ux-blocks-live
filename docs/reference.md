# Reference

## Package identity

| Item | Value |
|------|-------|
| Composer | `symfinity/ux-blocks-live` |
| Bundle | `Symfinity\UxBlocksLive\SymfinityUxBlocksLiveBundle` |
| Registry prefix | `blocks.live` |
| Role count | 5 |
| Interaction | `live` (LiveComponent) |

## Fragment ids

| Role | Fragment |
|------|----------|
| combobox | `blocks.live.combobox` |
| date-picker | `blocks.live.date-picker` |
| date-range-picker | `blocks.live.date-range-picker` |
| tags-input | `blocks.live.tags-input` |
| data-table-chrome-interactive | `blocks.live.data-table-chrome-interactive` |

## Commands

```bash
composer test      # PHPUnit in package root
composer phpstan   # Static analysis
```

In the product monorepo:

```bash
./bin/php vendor/bin/phpunit packages/ux-blocks-live/tests/
./bin/php vendor/bin/phpstan analyse -c packages/ux-blocks-live/phpstan.neon.dist
```

## Related packages

| Package | Role |
|---------|------|
| [ux-blocks-interactive](https://docs.symfinity.dev/ux-blocks-interactive) | Required upstream — client `stl` tier |
| [ux-blocks-extended](https://docs.symfinity.dev/ux-blocks-extended) | Compounds consumed transitively |
| [ui-kernel](https://docs.symfinity.dev/ui-kernel) | Optional theme CSS |

## See also

- [Components](components.md)
- [CHANGELOG](../CHANGELOG.md)
