# Configuration

UX Blocks Live ships **zero required app YAML**. The bundle prepends AssetMapper paths, Twig template paths, and LiveComponent registration at compile time.

## What the bundle configures

| Concern | Behavior |
|---------|----------|
| AssetMapper | Maps `assets/` to logical namespace `ux-blocks-live` |
| Twig templates | Namespace `UxBlocksLive` → `templates/` |
| Live components | `Symfinity\UxBlocksLive\Twig\Components\*Live` → component templates |
| Role registry | `config/ux_roles.yaml` (revision **1.4**) — read-only reference inside the package |
| Services | Autowired listeners — see bundle `config/services.yaml` |

Applications **do not** copy bundle `config/` into `config/packages/`.

## Required Symfony bundles

| Bundle | Purpose |
|--------|---------|
| `symfony/ux-live-component` | Server-synchronized component state |
| `symfony/ux-turbo` | Frame and stream updates for live re-renders |
| `symfony/stimulus-bundle` | Stimulus controllers shipped with each role |
| `symfony/ux-twig-component` | Base Twig component infrastructure |

Install them before or with `symfinity/ux-blocks-live` — see [Installation](installation.md).

## Themed apps (optional ui-kernel)

Role CSS uses `var(--ui-*)` tokens. When **symfinity/ui-kernel** is installed, include theme CSS in your layout — see ui-kernel [theme-preference](https://github.com/symfinity/ui-kernel/blob/main/docs/theme-preference.md).

## Turbo and LiveComponent

Live roles emit `data-controller` hooks for Stimulus and participate in LiveComponent re-renders. For partial page updates, wrap live widgets in `<turbo-frame>` or use Turbo streams from your controllers — standard Symfony UX guidance applies.

## See also

- [Installation](installation.md)
- [Components](components.md)
- [Troubleshooting](troubleshooting.md)
