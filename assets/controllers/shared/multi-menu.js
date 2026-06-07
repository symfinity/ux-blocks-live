/**
 * Shared multi-trigger menu helpers (menubar, navigation-menu).
 */
import { applyRovingTabindex, rovingKeydown } from './menu-roving.js';
import { restoreFocus, trapFocus } from './overlay-base.js';

export function enabledTriggers(triggerTargets) {
    return triggerTargets.filter((el) => !el.disabled);
}

export function itemsInContent(content, targetName) {
    return [...content.querySelectorAll(`[data-symfony--ux-blocks-live--${targetName}-target="item"]`)]
        .filter((el) => !el.disabled);
}

export function hideAllContents(contentTargets) {
    contentTargets.forEach((content) => {
        content.hidden = true;
    });
}

export function collapseTriggers(triggerTargets) {
    triggerTargets.forEach((trigger) => {
        trigger.setAttribute('aria-expanded', 'false');
    });
}

export function bindDocumentClose(controller, onKeydown, onClick) {
    document.addEventListener('keydown', onKeydown);
    document.addEventListener('click', onClick);
}

export function unbindDocumentClose(onKeydown, onClick) {
    document.removeEventListener('keydown', onKeydown);
    document.removeEventListener('click', onClick);
}

export function handleSubmenuKeydown(event, content, items, itemIndex, orientation) {
    trapFocus(content, event);

    const next = rovingKeydown(event, items, itemIndex, orientation);
    if (next !== itemIndex) {
        applyRovingTabindex(items, next);
    }

    return next;
}

export { applyRovingTabindex, restoreFocus, rovingKeydown };
