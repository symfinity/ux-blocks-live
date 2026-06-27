# Porting reference — extended REF sources

**Planning:** symfinity **025** `DONE`  
**Contract:** port-semantics-extended

## REF checkout (read-only)

Same base as core — symfony/ux-toolkit `3.x`, `kits/shadcn/` for most roles; Catalyst / DaisyUI for noted exceptions.

```bash
git clone --depth 1 --branch 3.x https://github.com/symfony/ux-toolkit.git var/ref/ux-toolkit
# templates: var/ref/ux-toolkit/kits/shadcn/{slug}/templates/components/
```

**MUST NOT** vendor `kits/` into `packages/ux-blocks-live/`.

## Port transform (extended)

1. Copy Twig shape and prop defaults from REF.
2. Remove `html_cva`, `|tailwind_merge`, utility class strings.
3. Set `data-ui-role` + `data-ui-fragment="blocks.live.{role}"` on component root.
4. Port REF Stimulus into `assets/controllers/{role}_controller.js` — strip `@symfony/ux-toolkit` imports.
5. Add `#[AsTwigComponent]` PHP class under `Symfinity\UxBlocksLive\Twig\Components\`.

See port-semantics-ref for shared rules.

## Primary REF map

Documented in port-semantics-extended.
