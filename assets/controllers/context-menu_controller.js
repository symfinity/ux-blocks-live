import { Controller } from '@hotwired/stimulus';
import { applyRovingTabindex, rovingKeydown } from './shared/menu-roving.js';
import { restoreFocus, trapFocus } from './shared/overlay-base.js';

export default class extends Controller {
    static targets = ['trigger', 'content', 'item'];

    connect() {
        this._open = false;
        this._activeIndex = 0;
        this._onContextMenu = this._onContextMenu.bind(this);
        this._onDocumentKeydown = this._onDocumentKeydown.bind(this);
        this._onDocumentClick = this._onDocumentClick.bind(this);

        if (this.hasTriggerTarget) {
            this.triggerTarget.addEventListener('contextmenu', this._onContextMenu);
        }
    }

    disconnect() {
        this.close();
        if (this.hasTriggerTarget) {
            this.triggerTarget.removeEventListener('contextmenu', this._onContextMenu);
        }
    }

    _onContextMenu(event) {
        event.preventDefault();
        this.openAt(event.clientX, event.clientY, event.currentTarget);
    }

    openAt(x, y, trigger = this.triggerTarget) {
        if (!this.hasContentTarget) {
            return;
        }

        this._open = true;
        this._lastTrigger = trigger;
        const menu = this.contentTarget;
        menu.hidden = false;
        menu.style.position = 'fixed';
        menu.style.left = `${x}px`;
        menu.style.top = `${y}px`;
        menu.style.zIndex = 'var(--ui-z-popover, 1100)';

        const items = this.itemTargets.filter((el) => !el.disabled);
        if (items.length > 0) {
            applyRovingTabindex(items, 0);
            this._activeIndex = 0;
            items[0].focus();
        }

        document.addEventListener('keydown', this._onDocumentKeydown);
        document.addEventListener('click', this._onDocumentClick);
    }

    close() {
        if (!this._open) {
            return;
        }

        this._open = false;
        if (this.hasContentTarget) {
            this.contentTarget.hidden = true;
        }

        document.removeEventListener('keydown', this._onDocumentKeydown);
        document.removeEventListener('click', this._onDocumentClick);
        restoreFocus(this._lastTrigger);
    }

    _onDocumentClick(event) {
        if (!this.element.contains(event.target)) {
            this.close();
        }
    }

    _onDocumentKeydown(event) {
        if (event.key === 'Escape') {
            event.preventDefault();
            this.close();
            return;
        }

        if (!this._open || !this.hasContentTarget) {
            return;
        }

        trapFocus(this.contentTarget, event);

        const items = this.itemTargets.filter((el) => !el.disabled);
        const next = rovingKeydown(event, items, this._activeIndex, 'vertical');
        if (next !== this._activeIndex) {
            this._activeIndex = next;
            applyRovingTabindex(items, next);
        }
    }
}
