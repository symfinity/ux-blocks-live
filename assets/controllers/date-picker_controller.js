import { Controller } from '@hotwired/stimulus';
import { restoreFocus, trapFocus } from './shared/overlay-base.js';

export default class extends Controller {
    static targets = ['trigger', 'content', 'value'];

    connect() {
        this._open = false;
        this._onDocumentKeydown = this._onDocumentKeydown.bind(this);
        this._onDocumentClick = this._onDocumentClick.bind(this);
        this._onCalendarSelect = this._onCalendarSelect.bind(this);

        this.element.addEventListener('ux-blocks-live:calendar-select', this._onCalendarSelect);

        if (this.hasTriggerTarget) {
            this.triggerTarget.setAttribute('aria-haspopup', 'dialog');
            this.triggerTarget.setAttribute('aria-expanded', 'false');
            if (this.hasContentTarget) {
                if (!this.contentTarget.id) {
                    this.contentTarget.id = `date-picker-popover-${Math.random().toString(36).slice(2, 9)}`;
                }
                this.triggerTarget.setAttribute('aria-controls', this.contentTarget.id);
            }
        }
    }

    disconnect() {
        this.close();
        document.removeEventListener('keydown', this._onDocumentKeydown);
        document.removeEventListener('click', this._onDocumentClick);
        this.element.removeEventListener('ux-blocks-live:calendar-select', this._onCalendarSelect);
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

        document.addEventListener('keydown', this._onDocumentKeydown);
        document.addEventListener('click', this._onDocumentClick);

        const focusable = this.contentTarget.querySelector('button, input');
        focusable?.focus();
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

    _onCalendarSelect(event) {
        const date = event.detail?.date;
        if (!date) {
            return;
        }

        if (this.hasValueTarget) {
            this.valueTarget.textContent = date;
        }
        if (this.hasTriggerTarget) {
            this.triggerTarget.dataset.value = date;
        }

        this.element.dataset.value = date;
        this.element.dispatchEvent(
            new CustomEvent('ux-blocks-live:date-picker-change', {
                bubbles: true,
                detail: { date },
            }),
        );

        this.close();
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
    }
}
