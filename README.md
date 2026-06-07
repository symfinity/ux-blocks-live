# Ux Blocks Live

**Interactive tier — default `stl`; not Symfony LiveComponent.**

Symfinity UX Blocks Live ships Stimulus-backed interactive widgets with `blocks.live.*` fragment ids. Requires `symfinity/ux-blocks-extended` (compounds) and transitively `symfinity/ux-blocks-core` (atoms).

## Tier model (054)

| Tier | Package | Prefix | Interaction |
|------|---------|--------|-------------|
| Foundation | `ux-blocks-core` | `blocks` | `nat` atoms |
| Application | `ux-blocks-extended` | `blocks.ext` | `nat`/`act` compounds |
| **Interactive** | **`ux-blocks-live`** | **`blocks.live`** | **`stl`** widgets |

## Registry

See `config/ux_roles.yaml` — **30** shipped `stl` roles (including `collapsible` from core and `data-table-chrome-interactive` split from extended).

Deprecated one-cycle aliases: `blocks.ext.{role}` → `blocks.live.{role}` for former extended stl roles.

## Requirements

- PHP 8.2+
- Symfony 7.4+ / 8.0+
- `symfinity/ux-blocks-extended`
