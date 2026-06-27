# Data table chrome interactive

Toolbar chrome for sort, filter, and pagination — live state for data tables.

## When to use

Use **DataTableChromeInteractiveLive** above table markup when sort/filter/page controls must sync to the server and re-render via LiveComponent.

## Guidelines

**Do**

- Compose around your own `<table>` or grid body — this role supplies chrome only.
- Bind `sort`, `filter`, and `page` to your query layer in LiveComponent actions or parent controllers.
- Keep filter labels visible for screen readers.

**Don't**

- Expect built-in row data fetching — supply rows in the surrounding template.
- Mix with static extended-tier `DataTableChrome` when you need live pagination state.

## Usage

```twig
<twig:DataTableChromeInteractiveLive />

{# Your table body #}
<table>
    {# … #}
</table>
```

Variant previews render live from `config/component-examples/data-table-chrome-interactive.yaml`.

## API Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `sort` | `string` | `''` | Writable sort key |
| `filter` | `string` | `''` | Writable filter query |
| `page` | `int` | `1` | Writable page index |

Supports optional `act` integration when **ui-action** is present — see extended [Data table chrome](https://docs.symfinity.dev/ux-blocks-extended/components/data-table-chrome).

## Accessibility

- Sort and filter controls need visible labels.
- Announce page changes when using live updates without full navigation.

## Related

- [Extended DataTableChrome](https://docs.symfinity.dev/ux-blocks-extended/components/data-table-chrome)
- [Usage](../usage.md)
