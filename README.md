<div align="center">

# UX Blocks Live

### LiveComponent widgets with blocks.live fragments

[![PHP Version](https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat&logo=php&logoColor=white)](composer.json)
[![Symfony](https://img.shields.io/badge/Symfony-7.4+-343434?style=flat&logo=symfony&logoColor=white)](composer.json)
<br/>
[![CI](https://github.com/symfinity/ux-blocks-live/actions/workflows/ci.yml/badge.svg)](https://github.com/symfinity/ux-blocks-live/actions/workflows/ci.yml)
<br/>
[![Release](https://img.shields.io/packagist/v/symfinity/ux-blocks-live.svg?style=flat&logo=packagist&logoColor=white)](https://packagist.org/packages/symfinity/ux-blocks-live)
[![Downloads](https://img.shields.io/packagist/dt/symfinity/ux-blocks-live.svg?style=flat&logo=packagist&logoColor=white)](https://packagist.org/packages/symfinity/ux-blocks-live)
[![License](https://img.shields.io/badge/license-MIT-blue.svg?style=flat)](LICENSE)

</div>

> [!NOTE]
> **Read-only mirror.**
> See [CONTRIBUTING.md](CONTRIBUTING.md) for how to propose changes.

## Features

- **5 LiveComponent roles** — combobox, date pickers, tags input, and interactive data table
- **Server-synchronized (`live`)** — Symfony UX LiveComponent + Turbo
- **Registry-aligned** — `blocks.live.*` fragment ids
- **Requires interactive tier** — builds on `symfinity/ux-blocks-interactive`

## Interaction profile

| Token | In this package |
|-------|-----------------|
| `live` | Default — LiveComponent server sync |
| `act` | Optional on interactive data table chrome |

## Component inventory


<!-- ux-blocks:registry:start -->
| Role | Twig | Interaction | Fragment | Status |
|------|------|-------------|----------|--------|
| combobox | ComboboxLive | live | `blocks.live.combobox` | shipped |
| date-picker | DatePickerLive | live | `blocks.live.date-picker` | shipped |
| date-range-picker | DateRangePickerLive | live | `blocks.live.date-range-picker` | shipped |
| tags-input | TagsInputLive | live | `blocks.live.tags-input` | shipped |
| data-table-chrome-interactive | DataTableChromeInteractiveLive | live, act | `blocks.live.data-table-chrome-interactive` | shipped |
<!-- ux-blocks:registry:end -->

## Prerequisites

Add the [symfinity/recipes](https://github.com/symfinity/recipes) Flex endpoint to your project's `composer.json` (see [recipes README](https://github.com/symfinity/recipes/blob/main/README.md)) — recipes are not in Symfony's official recipe repository yet.

## Installation

```bash
composer require symfinity/ux-blocks-live
```

See [Installation](docs/installation.md).

## Quick Start

```twig
<twig:ComboboxLive name="country" :options="countries" />
```

See [Quick start](docs/quickstart.md) for the full walkthrough.

## Documentation

- **[Quick start](docs/quickstart.md)** — minimal setup path
- **[Installation](docs/installation.md)** — Flex, dependencies, verify
- **[Configuration](docs/configuration.md)** — bundle and app options
- **[Usage](docs/usage.md)** — day-to-day patterns
- **[Upgrade](docs/upgrade.md)** — version migrations

## Requirements

- PHP 8.2 or higher
- Symfony 7.4 or 8.x
- `symfinity/ux-blocks-interactive` ^0.1
- `symfony/ux-live-component` and `symfony/ux-turbo`

## Support

- [GitHub Issues](https://github.com/symfinity/ux-blocks-live/issues)
- [Security](.github/SECURITY.md)
- [Contributing](CONTRIBUTING.md)

## License

[MIT](LICENSE)
