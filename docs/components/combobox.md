# Combobox

Searchable single-select with optional creatable entries — server state via LiveComponent.

## When to use

Use **ComboboxLive** when the selected value must sync to the server without a full form post — filters, inline editors, and wizard steps. For static client-only comboboxes, see **ux-blocks-interactive**.

## Guidelines

**Do**

- Set a visible label or `aria-label` on the input.
- Use `creatable: true` when users may add values not in the preset list.
- Keep option lists reasonably sized; paginate large datasets server-side.

**Don't**

- Use for simple native `<select>` with a fixed small set — prefer form Select from **ux-blocks-form**.
- Rely on colour alone to indicate selection state.

## Usage

```twig
<twig:ComboboxLive name="country" placeholder="Search countries…" />

<twig:ComboboxLive name="label" :creatable="true" placeholder="Search or create…" />
```

### Sending the selection to the server

`ComboboxLive` renders a hidden `data-model="selected"` input inside its root. Picking an item writes the item's `data-value` (or its label) into that input, so the `selected` LiveProp updates on the next Live request. `name` goes on the same hidden input, so a plain form post also carries the value.

```twig
<twig:ComboboxLive name="country" selected="fr">
    <twig:Combobox:Trigger>France</twig:Combobox:Trigger>
    <twig:Combobox:Content>
        <twig:Combobox:Item data-value="fr">France</twig:Combobox:Item>
        <twig:Combobox:Item data-value="de" data-action="click->analytics#track">Germany</twig:Combobox:Item>
    </twig:Combobox:Content>
</twig:ComboboxLive>
```

A `data-action` on `Combobox:Item` is added after the built-in select action; both run.

Variant previews render live from `config/component-examples/combobox.yaml`.

## API Reference

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `selected` | `string?` | `null` | Writable selected value |
| `creatable` | `bool` | `false` | Allow committing free-text when no option matches |
| `onCreateValue` | `string?` | `null` | Hook for custom create handling |
| `preventDuplicates` | `bool` | `true` | Block duplicate labels in creatable mode |

`name` names the hidden selection input. Pass `placeholder`, `disabled`, and native attributes on the component tag.

## Accessibility

- Input exposes combobox/listbox roles when the list is open.
- Active option is tracked with `aria-activedescendant` when the listbox is expanded.
- Ensure an accessible name via `<label>` or `aria-label`.

## Related

- [Date picker](date-picker.md)
- [Tags input](tags-input.md)
