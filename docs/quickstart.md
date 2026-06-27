# Quick start

Use UX Blocks Live components in a Symfony app with ui-kernel theme CSS and LiveComponent enabled.

## Prerequisites

[Installation](installation.md) completed — upstream tiers plus `symfinity/ux-blocks-live`. Add `symfinity/ui-kernel` for themed apps. Confirm LiveComponent and Turbo bundles are registered.

## 1. Include ui-kernel CSS

Live roles rely on ui-kernel design tokens. In your base layout `<head>`:

```twig
{# templates/base.html.twig #}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{% block title %}My app{% endblock %}</title>
    {{ ui_kernel_theme_boot_script() }}
    {{ ui_kernel_css()|raw }}
    {% block stylesheets %}{% endblock %}
</head>
<body>
    {% block body %}{% endblock %}
</body>
</html>
```

## 2. Render a LiveComponent

Use `*Live` Twig component tags — server state syncs through Symfony UX LiveComponent:

```twig
<twig:ComboboxLive name="country" placeholder="Choose a country…" />

<twig:TagsInputLive name="tags" placeholder="Add tags…" />

<twig:DateRangePickerLive placeholderStart="Start" placeholderEnd="End" />
```

Wrap pages that mutate live state in a Turbo frame or drive when using partial updates — see [Configuration](configuration.md).

## Next steps

- [Components](components.md) — handbook index
- [Combobox](components/combobox.md) · [Tags input](components/tags-input.md)
- [Usage](usage.md) — patterns and form binding
- [Verification](verification.md) — clean-app smoke
