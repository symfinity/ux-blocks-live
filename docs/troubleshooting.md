# Troubleshooting

## LiveComponent not updating

| Symptom | Check |
|---------|--------|
| UI frozen after click | LiveComponent and Turbo bundles registered in `config/bundles.php` |
| Full page reload instead of partial update | Wrap content in `<turbo-frame>` or return Turbo streams |
| 419 / CSRF errors | Ensure forms include CSRF tokens; LiveComponent requests need valid session |

## Stimulus controller missing

Confirm AssetMapper compiled paths include `ux-blocks-live` controllers:

```bash
php bin/console debug:asset-map | grep ux-blocks-live
```

## Styles look unstyled

Live role CSS uses ui-kernel tokens. Install `symfinity/ui-kernel` and include `ui_kernel_css()` in your layout — see [quick start](quickstart.md).

## Wrong component tier

Tabs, menus, and toasts are **interactive** (`blocks.int.*`) — require `symfinity/ux-blocks-interactive`, not this package.

## Composer resolution failures

`symfinity/ux-blocks-live` requires `symfinity/ux-blocks-interactive` `^0.1` on Packagist. Tag interactive before live in the same release wave — see package [CHANGELOG](../CHANGELOG.md).

## See also

- [Installation](installation.md)
- [Verification](verification.md)
