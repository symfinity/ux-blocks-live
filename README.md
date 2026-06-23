# Ux Blocks Live

**LiveComponent tier — server-synchronized widgets via Symfony UX LiveComponent.**

Symfinity UX Blocks Live ships five `#[AsLiveComponent]` roles with `blocks.live.*` fragment ids. Requires `symfinity/ux-blocks-interactive`, **`symfony/ux-live-component`**, and **`symfony/ux-turbo`**.

## Tier model (057)

| Tier | Package | Prefix | Interaction |
|------|---------|--------|-------------|
| Interactive | `ux-blocks-interactive` | `blocks.int` | `stl` client widgets |
| **Live** | **`ux-blocks-live`** | **`blocks.live`** | **`live`** LiveComponents |

## Registry

See `config/ux_roles.yaml` — **5** LiveComponent roles: `combobox`, `date-picker`, `date-range-picker`, `tags-input`, `data-table-chrome-interactive`.

**MUST NOT** conflate with pre-057 `stl` tier — that catalog moved to `ux-blocks-interactive`.

## Maintainer Sass pipeline (120)

Author role CSS in `assets/scss/partials/` + `_bundle.scss`. From product monorepo root:

```bash
cd src/symfinity
bin/blocks-css-compile --package=ux-blocks-live --check
bin/ux-blocks-scss-audit --package=ux-blocks-live --check
```

See [ux-blocks maintainer Sass pipeline](../ux-blocks/README.md#maintainer--sass-author-pipeline-120).

## Requirements

- PHP 8.2+
- Symfony 7.4+ / 8.0+
- `symfinity/ux-blocks-interactive`
- `symfony/ux-live-component`
- `symfony/ux-turbo`

## Stimulus assets

Regenerate `assets/package.json` from on-disk controllers before release or when adding roles:

```bash
php bin/scaffold-assets-package-json.php
```

PHPUnit `StimulusControllersTest` guards that every registered controller has a matching `*_controller.js` file.


<!-- ux-blocks:registry:start -->
| Role | Twig | Interaction | Fragment | Status |
|------|------|-------------|----------|--------|
| combobox | ComboboxLive | live | `blocks.live.combobox` | shipped |
| date-picker | DatePickerLive | live | `blocks.live.date-picker` | shipped |
| date-range-picker | DateRangePickerLive | live | `blocks.live.date-range-picker` | shipped |
| tags-input | TagsInputLive | live | `blocks.live.tags-input` | shipped |
| data-table-chrome-interactive | DataTableChromeInteractiveLive | live, act | `blocks.live.data-table-chrome-interactive` | shipped |
<!-- ux-blocks:registry:end -->
