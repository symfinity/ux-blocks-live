# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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
