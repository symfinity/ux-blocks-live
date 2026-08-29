/**
 * Shared overlay helpers — focus trap and inert backdrop (internal).
 */
export function trapFocus(container, event) {
    if (event.key !== 'Tab') {
        return;
    }

    const focusable = container.querySelectorAll(
        'a[href], button:not([disabled]), input:not([disabled]), select:not([disabled]), textarea:not([disabled]), [tabindex]:not([tabindex="-1"])',
    );

    if (focusable.length === 0) {
        return;
    }

    const first = focusable[0];
    const last = focusable[focusable.length - 1];

    if (event.shiftKey && document.activeElement === first) {
        event.preventDefault();
        last.focus();
    } else if (!event.shiftKey && document.activeElement === last) {
        event.preventDefault();
        first.focus();
    }
}

export function restoreFocus(trigger) {
    if (trigger && typeof trigger.focus === 'function') {
        trigger.focus();
    }
}
