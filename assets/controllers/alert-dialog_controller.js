import { Controller } from '@hotwired/stimulus';
import { restoreFocus, trapFocus } from './shared/overlay-base.js';

export default class extends Controller {
    static targets = ['trigger', 'content', 'title', 'description', 'footer'];

    connect() {
        this._open = false;
        this._onKeydown = this._onKeydown.bind(this);
    }

    disconnect() {
        this.close();
    }

    open(event) {
        event?.preventDefault();
        if (!this.hasContentTarget) {
            return;
        }

        this._open = true;
        this._lastTrigger = event?.currentTarget ?? this.triggerTarget;
        const dialog = this.contentTarget;

        if (dialog.tagName === 'DIALOG' && typeof dialog.showModal === 'function') {
            dialog.removeAttribute('hidden');
            dialog.showModal();
        } else {
            dialog.hidden = false;
        }

        this._lastTrigger?.setAttribute('aria-expanded', 'true');
        document.addEventListener('keydown', this._onKeydown);
        this._focusInitial();
    }

    close() {
        if (!this._open || !this.hasContentTarget) {
            return;
        }

        this._open = false;
        const dialog = this.contentTarget;

        if (dialog.tagName === 'DIALOG' && dialog.open) {
            dialog.close();
        }
        dialog.setAttribute('hidden', 'hidden');

        if (this.hasTriggerTarget) {
            this.triggerTarget.setAttribute('aria-expanded', 'false');
        }

        document.removeEventListener('keydown', this._onKeydown);
        restoreFocus(this._lastTrigger);
    }

    confirm() {
        this.close();
    }

    _onKeydown(event) {
        if (event.key === 'Escape') {
            event.preventDefault();
            this.close();
            return;
        }

        if (this._open && this.hasContentTarget) {
            trapFocus(this.contentTarget, event);
        }
    }

    _focusInitial() {
        const focusable = this.contentTarget.querySelector(
            '[data-ui-role="alert-dialog-action"], [data-ui-role="alert-dialog-cancel"], button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])',
        );
        (focusable ?? this.contentTarget).focus?.();
    }
}
