# Usage

Patterns for **symfinity/ux-blocks-live** LiveComponents.

## Featured components

- **[Combobox](components/combobox.md)** — searchable single-select with optional creatable mode
- **[Tags input](components/tags-input.md)** — multi-value token field with live add/remove
- **[Date range picker](components/date-range-picker.md)** — paired start/end date selection

## Live interaction model

All roles use **live** interaction — writable `LiveProp` values sync to the server on user action. Prefer `*Live` component names in templates:

```twig
<twig:ComboboxLive name="status" :creatable="true" />
```

Do not mix static interactive-tier tags (`Combobox`, `Tabs`, …) when you need server state — those ship in **ux-blocks-interactive**.

## Form binding

Pass `name` on components that emit hidden inputs or participate in form posts. Combine with Symfony Form types where your app maps request data to DTOs — the LiveComponent holds transient UI state; your controller persists on submit.

## Data table chrome

**[Data table chrome interactive](components/data-table-chrome-interactive.md)** exposes sort, filter, and pagination props as live state — compose around your table body markup.

## Theme CSS

Include UI Kernel theme CSS — see [quick start](quickstart.md) for the boot snippet.

## See also

- [Components](components.md) · [Configuration](configuration.md) · [Troubleshooting](troubleshooting.md)
