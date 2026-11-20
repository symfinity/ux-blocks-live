# Changelog

All notable changes to **symfinity/ux-blocks-live** are documented here.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.1.4] - 2026-11-20

### Changed

- The Sass build keeps quoted attribute selectors (`extra.symfinity.sass.quote_attributes`). Shipped role CSS is unchanged from 0.1.3

## [0.1.3] - 2026-11-20

### Fixed

- Combobox, tags input, date pickers, and the data table chrome use the Stimulus names this package registers (`symfinity--ux-blocks-live--…`). The templates no longer emit `symfony--ux-blocks-live--…`
- ComboboxLive writes the chosen value into a hidden field that Live Component reads. A caller action on a combobox item stays beside the built-in select action
- The bundle publishes `ux_blocks_live.package_dir`, so the core role registry can load this tier's catalogue and the page can receive this tier's styles
- PHPUnit bootstrap registers this package's PSR-4 prefixes from `composer.json` after loading the monorepo or package autoload, and narrows the decoded autoload sections before reading `psr-4`

## [0.1.2] - 2026-07-05

### Added

- Handbook [verification.md](docs/verification.md) — P2 integration profile and clean-app smoke (`composer require`, LiveComponent registry markup checks)
- `integration_profile: P2` frontmatter on handbook index
- [Configuration — styling without ui-kernel](docs/configuration.md#styling-without-ui-kernel) — inline upstream tier stylesheets when Chameleon theme CSS is not installed

### Changed

- **Grouped component examples** — all five `config/component-examples/*.yaml` manifests use `groups[]` with `slot_twig` for symfinity-docs handbook SSR
- **Role CSS cascade** — committed `blocks-live.css` wraps tier output in `@layer blocks.live` for ui-kernel layer ordering
- **PHPUnit bootstrap** — `tests/bootstrap.php` resolves monorepo or split-mirror Composer autoload; optional `tests/bootstrap.local.php` hook
- Handbook: quickstart documents optional ui-kernel vs inline tier CSS; verification and troubleshooting cross-link the no-kernel styling path

### Notes

- No Twig component props or registry role ids changed — OOTB handbook and CSS cascade hygiene after **v0.1.1**
- Pair with `symfinity/ux-blocks-core` **^0.1.6** (or newer) for automatic inline tier CSS when live fragments render
- Upgrading from **0.1.1** needs no config edits; clear Symfony cache if AssetMapper or Twig cached CSS in dev

## [0.1.1] - 2026-06-29

### Added

- **ROADMAP.md** — public milestone table for the 0.1.x → 1.0.x release line
- **SUPPORTERS.md** and Composer **`funding` metadata for [GitHub Sponsors](https://github.com/sponsors/serotoninja)
- `.github/FUNDING.yml`** — GitHub Sponsors link on the split mirror

### Changed

- **Split mirror CI** — Composer package cache and `GITHUB_TOKEN` authentication so GitHub Actions reliably resolves `symfinity/*` dependencies across the PHP × Symfony matrix; PHPStan on every cell

### Notes

- No Twig component, registry role id, or LiveComponent prop changes — documentation and CI maintenance patch after `v0.1.0`
- Upgrading from **0.1.0** needs no template or config edits

## [0.1.0] - 2026-06-27

### Added

- Symfony bundle `SymfinityUxBlocksLiveBundle` — LiveComponent catalog tier for UX Blocks
- Five LiveComponent roles with `blocks.live.*` fragment ids:
  - `ComboboxLive` — searchable single-select with optional creatable mode
  - `DatePickerLive` — single-date selection
  - `DateRangePickerLive` — paired start/end dates
  - `TagsInputLive` — multi-value token field
  - `DataTableChromeInteractiveLive` — sort, filter, and pagination chrome (supports optional `act` interactions)
- Role registry in `config/ux_roles.yaml` aligned with the UX Blocks fragment catalog
- Asset Mapper Stimulus controllers and packaged role CSS (`assets/controllers/`, `assets/styles/blocks-live.css`)
- Five `config/component-examples/{role}.yaml` manifests for symfinity-docs handbook SSR
- Flex recipe `0.1`: registers the bundle on all environments
- Consumer handbook under `docs/`: installation, quickstart, configuration, usage, five component pages, verification, upgrade, and troubleshooting

### Notes

- Hard dependency on `symfinity/ux-blocks-interactive` ^0.1 (transitively core, extended, and form tiers)
- Requires `symfony/ux-live-component` and `symfony/ux-turbo`
- PHP **8.2**+; Symfony **7.4** or **8.x**
- Optional: `symfinity/ui-kernel` for themed CSS in production layouts — see handbook quickstart
