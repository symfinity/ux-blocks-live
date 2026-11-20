# Upgrade

## 0.1.3

Templates use the Stimulus names this package registers (`symfinity--ux-blocks-live--…`). They no longer emit `symfony--ux-blocks-live--…`.

ComboboxLive writes the chosen value into a hidden field that Live Component reads. A caller action on a combobox item stays beside the built-in select action.

The bundle publishes `ux_blocks_live.package_dir`, so core can load this tier's role catalogue.

```bash
composer update symfinity/ux-blocks-live
```

After upgrade, clear the Symfony cache and hard-refresh the browser so the controller scripts reload. Custom scripts that still target `symfony--ux-blocks-live--…` need the `symfinity--` names.

## 0.1.2

Patch release after [v0.1.1](https://github.com/symfinity/ux-blocks-live/releases/tag/v0.1.1). OOTB handbook (P2 verification, styling without ui-kernel), grouped component examples, `@layer blocks.live` CSS, and split-mirror PHPUnit bootstrap — no LiveComponent API changes.

```bash
composer update symfinity/ux-blocks-live
```

After upgrade:

1. No config or registry migrations — existing `blocks.live.*` fragment ids are unchanged.
2. Optional: pair with `symfinity/ux-blocks-core` **^0.1.6** for automatic inline tier CSS on pages that render live roles.
3. Clear Symfony cache in dev if widgets look stale after the CSS layer change.

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
