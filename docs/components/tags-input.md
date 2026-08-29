# Tags input

Multi-value token field with live add and remove actions.

## When to use

Use **TagsInputLive** for skill tags, filter chips backed by server state, and multi-value metadata fields.

## Guidelines

**Do**

- Set `maxTags` when the UI must cap entries.
- Use `allowDuplicates: false` (default) for unique tag sets.
- Provide `placeholder` text describing acceptable values.

**Don't**

- Use for single-select — prefer [Combobox](combobox.md).
- Allow unbounded tags without server validation.

## Usage

```twig
<twig:TagsInputLive name="tags" placeholder="Add a tag and press Enter" />

<twig:TagsInputLive name="labels" :maxTags="5" delimiter="," />
```

Variant previews render live from `config/component-examples/tags-input.yaml`.

## API Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `tags` | `list<string\|array>` | `[]` | Writable tag collection |
| `draft` | `string` | `''` | Current input buffer |
| `name` | `string?` | `null` | Form field name |
| `placeholder` | `string?` | `null` | Input placeholder |
| `disabled` | `bool` | `false` | Disables editing |
| `invalid` | `bool` | `false` | Error styling |
| `maxTags` | `int?` | `null` | Maximum tag count |
| `allowDuplicates` | `bool` | `false` | Permit duplicate labels |
| `delimiter` | `string` | `','` | Character splitting pasted text |

Live actions: `addTag`, `removeTag`, `removeLastTag`.

## Accessibility

- Tag list should expose removable buttons with discernible names.
- Input requires an accessible label.

## Related

- [Combobox](combobox.md)
- [Filter patterns in interactive tier](https://docs.symfinity.dev/ux-blocks-interactive)
