# Changelog

All changes to **symfinity/ux-blocks-live** are currently on `main` (unreleased, untagged).

## [Unreleased]

### Added

- **046 R2:** `DateRangePicker`, `TagsInput`, and `TreeView` roles (`blocks.live.*` fragments + Stimulus)
- Opt-in **creatable** mode on `Combobox` (`creatable`, `preventDuplicates` props)
- Kernel CSS role-rules for three new extended roles

### Changed

- A11y hardening on `Combobox`, `DatePicker`, and core `Select` per 046 contract (`aria-controls`, `aria-activedescendant`, labeled select wrapper)

### Added (025 baseline)

- Symfony bundle `SymfinityUxBlocksLiveBundle` for integration
- Module `Controller`
- Module `Twig`
- Package configuration under `config/`
- Twig templates for UI integration
- Asset Mapper / Stimulus assets
- UX role registry (`config/ux_roles.yaml`)
- 25 component handbook pages under `docs/components/`
- Packages added/updated
