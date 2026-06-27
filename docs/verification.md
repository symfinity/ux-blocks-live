# Verification

Checks after installing **symfinity/ux-blocks-live** in a Symfony app.

## Local commands

```bash
composer test
composer phpstan
php bin/console debug:container --tag=twig.component | grep Live
```

## Browser or WebTestCase

Render a page with a LiveComponent and confirm registry markup:

- `data-ui-role="combobox"` (or matching role)
- `data-ui-fragment="blocks.live.combobox"`
- `data-controller` includes `symfony--ux-blocks-live--combobox`

## Clean-app smoke

On a fresh Symfony 7.4+ project with the symfinity/recipes Flex endpoint:

```bash
composer require symfinity/ux-blocks-core symfinity/ux-blocks-form symfinity/ux-blocks-extended symfinity/ux-blocks-interactive symfinity/ux-blocks-live symfony/ux-live-component symfony/ux-turbo
```

Add ui-kernel theme CSS to your layout, then render:

```twig
<twig:ComboboxLive name="demo" placeholder="Choose…" />
```

Load the page — expect HTTP 200 and `blocks.live.combobox` in the response body.

## See also

- [Quickstart](quickstart.md)
- [Troubleshooting](troubleshooting.md)
- [CHANGELOG](../CHANGELOG.md)
