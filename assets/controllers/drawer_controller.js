import { Controller } from '@hotwired/stimulus';
import { restoreFocus, trapFocus } from './shared/overlay-base.js';

export default class extends Controller {
    static targets = ['trigger', 'content', 'close'];

    static values = {
        side: { type: String, default: 'bottom' },
    };

    connect() {
        this._open = false;
        this._onKeydown = this._onKeydown.bind(this);
        this._onBackdropClick = this._onBackdropClick.bind(this);
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
        this.contentTarget.hidden = false;
        this.contentTarget.dataset.uiSide = this.sideValue;
        this._lastTrigger?.setAttribute('aria-expanded', 'true');
        document.addEventListener('keydown', this._onKeydown);
        document.addEventListener('click', this._onBackdropClick, true);
        this._ensureBackdrop();
        this.contentTarget.querySelector('[data-ui-role="drawer-close"], button')?.focus?.();
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

        document.removeEventListener('keydown', this._onKeydown);
        document.removeEventListener('click', this._onBackdropClick, true);
        this._removeBackdrop();
        restoreFocus(this._lastTrigger);
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

    _onBackdropClick(event) {
        if (this.hasContentTarget && !this.contentTarget.contains(event.target) && event.target?.dataset?.uiOverlayBackdrop !== undefined) {
            this.close();
        }
    }

    _ensureBackdrop() {
        if (this._backdrop) {
            return;
        }
        this._backdrop = document.createElement('div');
        this._backdrop.dataset.uiOverlayBackdrop = '';
        this._backdrop.hidden = false;
        this._backdrop.style.cssText = 'position:fixed;inset:0;background:color-mix(in srgb, var(--ui-color-text, #000) 40%, transparent);z-index:calc(var(--ui-z-modal, 1000) - 1);';
        document.body.appendChild(this._backdrop);
        if (this.hasContentTarget) {
            this.contentTarget.style.zIndex = 'var(--ui-z-modal, 1000)';
            this.contentTarget.style.position = 'fixed';
        }
    }

    _removeBackdrop() {
        this._backdrop?.remove();
        this._backdrop = null;
    }
}
