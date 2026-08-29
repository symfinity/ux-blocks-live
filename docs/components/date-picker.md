# Date picker

Single-date selection with live server synchronization.

## When to use

Use **DatePickerLive** for inline date fields where the chosen date must persist in LiveComponent state — booking widgets, filters, and settings panels.

## Guidelines

**Do**

- Pair with a visible label or `aria-label`.
- Format displayed dates consistently with your locale strategy.
- Validate `selected` on the server when binding to domain models.

**Don't**

- Use for date ranges — prefer [Date range picker](date-range-picker.md).
- Omit keyboard support — the Stimulus controller handles arrow keys when focused.

## Usage

```twig
<twig:DatePickerLive name="starts_on" placeholder="Pick a date" />
```

Variant previews render live from `config/component-examples/date-picker.yaml`.

## API Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `selected` | `string?` | `null` | Writable ISO or locale date string |

Pass `name`, `placeholder`, `disabled`, `invalid`, and native attributes on the tag.

## Accessibility

- Calendar grid exposes appropriate roles when open.
- Focus returns to the trigger after selection where supported.

## Related

- [Date range picker](date-range-picker.md)
- [Combobox](combobox.md)
