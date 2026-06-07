import { Controller } from '@hotwired/stimulus';
import { applyRovingTabindex, rovingKeydown } from './shared/menu-roving.js';
import { restoreFocus, trapFocus } from './shared/overlay-base.js';

export default class extends Controller {
    static targets = ['trigger', 'content', 'item'];

    connect() {
        this._open = false;
        this._activeIndex = 0;
        this._onDocumentKeydown = this._onDocumentKeydown.bind(this);
        this._onDocumentClick = this._onDocumentClick.bind(this);
    }

    disconnect() {
        this.close();
        document.removeEventListener('keydown', this._onDocumentKeydown);
        document.removeEventListener('click', this._onDocumentClick);
    }

    toggle(event) {
        event.preventDefault();
        event.stopPropagation();
        if (this._open) {
            this.close();
        } else {
            this.open(event.currentTarget);
        }
    }

    open(trigger = this.triggerTarget) {
        if (!this.hasContentTarget) {
            return;
        }

        this._open = true;
        this._lastTrigger = trigger;
        this.contentTarget.hidden = false;
        trigger.setAttribute('aria-expanded', 'true');

        const items = this.itemTargets.filter((el) => !el.disabled);
        if (items.length > 0) {
            applyRovingTabindex(items, 0);
            this._activeIndex = 0;
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
        if (this.hasTriggerTarget) {
            this.triggerTarget.setAttribute('aria-expanded', 'false');
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
