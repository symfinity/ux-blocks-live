# Quick start

Use UX Blocks Live components in a Symfony app with LiveComponent enabled.

## Prerequisites

[Installation](installation.md) completed — upstream tiers plus `symfinity/ux-blocks-live`. Confirm LiveComponent and Turbo bundles are registered.

## 1. Theme CSS (pick one)

**Recommended — ui-kernel:**

```bash
composer require symfinity/ui-kernel
```

```twig
{# templates/base.html.twig #}
<head>
    {{ ui_kernel_theme_boot_script() }}
    {{ ui_kernel_css()|raw }}
</head>
```

**Minimal — inline tier CSS** (no ui-kernel): see [Configuration — styling without ui-kernel](configuration.md#styling-without-ui-kernel).

## 2. Render a LiveComponent

Use `*Live` Twig component tags — server state syncs through Symfony UX LiveComponent. Tag syntax is the canonical embed path (no separate `component()` alias required):

```twig
<twig:ComboboxLive name="country" placeholder="Choose a country…" />

<twig:TagsInputLive name="tags" placeholder="Add tags…" />

<twig:DateRangePickerLive placeholderStart="Start" placeholderEnd="End" />
```

Wrap pages that mutate live state in a Turbo frame or drive when using partial updates — see [Configuration](configuration.md).

## Kiosk showroom (dev)

Maintainer matrix for all five live roles: install **`symfinity/ux-blocks-kiosk`** (dev-only) and open **`GET /kiosk/blocks/live`**. Requires ui-kernel + kiosk bundle — not part of consumer `composer require symfinity/ux-blocks-live`.

Dogfood: `make dogfood-new SLUG=ux-blocks-kiosk-lab` then `make dogfood-serve SLUG=ux-blocks-kiosk-lab`.

## Next steps

- [Components](components.md) — handbook index
- [Combobox](components/combobox.md) · [Tags input](components/tags-input.md)
- [Usage](usage.md) — patterns and form binding
- [Verification](verification.md) — clean-app smoke
