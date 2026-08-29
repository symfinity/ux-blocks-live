# Date range picker

Paired start and end date fields with live server synchronization.

## When to use

Use **DateRangePickerLive** for reporting filters, booking windows, and analytics date spans where both bounds must stay in sync with server state.

## Guidelines

**Do**

- Label both fields or provide a single group label.
- Validate that `start` ≤ `end` in your application layer.
- Use placeholders to clarify expected format.

**Don't**

- Split into two unrelated date inputs without live binding — use this component for coordinated state.

## Usage

```twig
<twig:DateRangePickerLive
    name="range"
    placeholderStart="Start date"
    placeholderEnd="End date"
/>
```

Variant previews render live from `config/component-examples/date-range-picker.yaml`.

## API Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `start` | `string?` | `null` | Writable range start |
| `end` | `string?` | `null` | Writable range end |
| `placeholderStart` | `string?` | `null` | Start field placeholder |
| `placeholderEnd` | `string?` | `null` | End field placeholder |
| `disabled` | `bool` | `false` | Disables both fields |
| `invalid` | `bool` | `false` | Error styling |

## Accessibility

- Each input needs an accessible name.
- Announce validation errors via linked hint or error text.

## Related

- [Date picker](date-picker.md)
- [Data table chrome interactive](data-table-chrome-interactive.md)
