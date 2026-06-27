# Installation

## Prerequisites

1. Add the [symfinity/recipes](https://github.com/symfinity/recipes) Flex endpoint to your project's `composer.json` (see [recipes README](https://github.com/symfinity/recipes/blob/main/README.md)).
2. Install the upstream tier chain — live builds on interactive, which requires extended and form:

```bash
composer require symfinity/ux-blocks-core symfinity/ux-blocks-form symfinity/ux-blocks-extended symfinity/ux-blocks-interactive
```

3. Enable Symfony UX LiveComponent and Turbo in your app (see [Configuration](configuration.md)).
4. For **styled** apps, install **ui-kernel** (theme CSS). The registry SDK `symfinity/ux-blocks` is pulled transitively from Packagist.

```bash
composer require symfinity/ui-kernel   # optional — themed apps only
```

## Composer

```bash
composer require symfinity/ux-blocks-interactive symfinity/ux-blocks-live
```

## Symfony Flex

The `0.1` recipe applies:

- Registers `SymfinityUxBlocksLiveBundle` for **all** environments
- No app config file is copied — the bundle auto-configures AssetMapper, Twig paths, and LiveComponent defaults

Ensure `symfony/ux-live-component` and `symfony/ux-turbo` are installed — they are hard dependencies of this package.

## Manual installation

When Flex is unavailable:

1. `composer require symfinity/ux-blocks symfinity/ux-blocks-core symfinity/ux-blocks-form symfinity/ux-blocks-extended symfinity/ux-blocks-interactive symfinity/ux-blocks-live symfony/ux-live-component symfony/ux-turbo`
2. Register `Symfinity\UxBlocksLive\SymfinityUxBlocksLiveBundle` in `config/bundles.php`
3. Enable AssetMapper, Stimulus, UX Twig Component, LiveComponent, and Turbo bundles

## Verify installation

```bash
php bin/console debug:container --tag=twig.component | grep -i ComboboxLive
```

## Next steps

[Quick start](quickstart.md) · [Verification](verification.md)
