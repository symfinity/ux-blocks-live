# Upgrade

## 0.1.1

Patch release after [v0.1.0](https://github.com/symfinity/ux-blocks-live/releases/tag/v0.1.0). Split-mirror CI, sponsorship metadata, and public roadmap — no LiveComponent API changes.

```bash
composer update symfinity/ux-blocks-live
```

After upgrade:

1. No config or registry migrations — existing `blocks.live.*` fragment ids are unchanged.
2. Clear Symfony cache only if you consume handbook routes via symfinity-docs in the same app.

## 0.1.0 (initial public release)

First Packagist release — five LiveComponent roles:

- `ComboboxLive`
- `DatePickerLive`
- `DateRangePickerLive`
- `TagsInputLive`
- `DataTableChromeInteractiveLive`

### Requirements

- PHP 8.2+
- Symfony 7.4 or 8.x
- `symfinity/ux-blocks-interactive` `^0.1`
- `symfony/ux-live-component` and `symfony/ux-turbo`

### Install

```bash
composer require symfinity/ux-blocks-interactive symfinity/ux-blocks-live
```

See [Installation](installation.md) for the full dependency chain and Flex recipe.

## Unreleased monorepo consumers

Path-repo installs from `symfinity/symfinity` may use `@dev` constraints until split tags land — track [CHANGELOG](../CHANGELOG.md).
