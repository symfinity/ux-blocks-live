# Upgrade

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
