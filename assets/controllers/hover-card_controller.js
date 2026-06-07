import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['trigger', 'content'];

    static values = {
        openDelay: { type: Number, default: 200 },
        closeDelay: { type: Number, default: 100 },
    };

    connect() {
        this._open = false;
        this._openTimer = null;
        this._closeTimer = null;
        this._onEnter = this._scheduleOpen.bind(this);
        this._onLeave = this._scheduleClose.bind(this);

        if (this.hasTriggerTarget) {
            this.triggerTarget.addEventListener('mouseenter', this._onEnter);
            this.triggerTarget.addEventListener('mouseleave', this._onLeave);
            this.triggerTarget.addEventListener('focusin', this._onEnter);
            this.triggerTarget.addEventListener('focusout', this._onLeave);
        }

        if (this.hasContentTarget) {
            this.contentTarget.addEventListener('mouseenter', this._cancelClose.bind(this));
            this.contentTarget.addEventListener('mouseleave', this._onLeave);
        }
    }

    disconnect() {
        this._clearTimers();
        if (this.hasTriggerTarget) {
            this.triggerTarget.removeEventListener('mouseenter', this._onEnter);
            this.triggerTarget.removeEventListener('mouseleave', this._onLeave);
            this.triggerTarget.removeEventListener('focusin', this._onEnter);
            this.triggerTarget.removeEventListener('focusout', this._onLeave);
        }
        this.close();
    }

    _scheduleOpen() {
        this._clearTimers();
        this._openTimer = window.setTimeout(() => this.open(), this.openDelayValue);
    }

    _scheduleClose() {
        this._clearTimers();
        this._closeTimer = window.setTimeout(() => this.close(), this.closeDelayValue);
    }

    _cancelClose() {
        if (this._closeTimer) {
            clearTimeout(this._closeTimer);
            this._closeTimer = null;
        }
    }

    open() {
        if (!this.hasContentTarget || this._open) {
            return;
        }

        this._open = true;
        const content = this.contentTarget;
        content.hidden = false;
        content.style.position = 'absolute';
        content.style.zIndex = 'var(--ui-z-popover, 1100)';
        content.style.marginBlockStart = 'var(--ui-space-xs)';

        if (this.hasTriggerTarget) {
            this.triggerTarget.setAttribute('aria-expanded', 'true');
        }
    }

    close() {
        if (!this._open || !this.hasContentTarget) {
            return;
        }

        this._open = false;
        this.contentTarget.hidden = true;
        if (this.hasTriggerTarget) {
            this.triggerTarget.setAttribute('aria-expanded', 'false');
        }
    }

    _clearTimers() {
        if (this._openTimer) {
            clearTimeout(this._openTimer);
            this._openTimer = null;
        }
        if (this._closeTimer) {
            clearTimeout(this._closeTimer);
            this._closeTimer = null;
        }
    }
}
