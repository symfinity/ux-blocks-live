import { Controller } from '@hotwired/stimulus';
import {
    applyRovingTabindex,
    bindDocumentClose,
    collapseTriggers,
    enabledTriggers,
    hideAllContents,
    itemsInContent,
    restoreFocus,
    rovingKeydown,
    unbindDocumentClose,
    handleSubmenuKeydown,
} from './shared/multi-menu.js';

export default class extends Controller {
    static targets = ['trigger', 'content', 'item'];

    connect() {
        this._openIndex = -1;
        this._triggerIndex = 0;
        this._itemIndex = 0;
        this._lastTrigger = null;
        this._onDocumentKeydown = this._onDocumentKeydown.bind(this);
        this._onDocumentClick = this._onDocumentClick.bind(this);
        this._onMenubarKeydown = this._onMenubarKeydown.bind(this);

        hideAllContents(this.contentTargets);
        collapseTriggers(this.triggerTargets);

        const triggers = enabledTriggers(this.triggerTargets);
        if (triggers.length > 0) {
            applyRovingTabindex(triggers, 0);
            this._triggerIndex = 0;
        }

        this.element.addEventListener('keydown', this._onMenubarKeydown);
    }

    disconnect() {
        this.closeSubmenu(false);
        this.element.removeEventListener('keydown', this._onMenubarKeydown);
        unbindDocumentClose(this._onDocumentKeydown, this._onDocumentClick);
    }

    toggle(event) {
        event.preventDefault();
        event.stopPropagation();

        const trigger = event.currentTarget;
        const index = this.triggerTargets.indexOf(trigger);
        if (index < 0) {
            return;
        }

        if (this._openIndex === index) {
            this.closeSubmenu();
        } else {
            this.openSubmenu(index, trigger);
        }
    }

    openSubmenu(index, trigger) {
        this.closeSubmenu(false);

        const content = this.contentTargets[index];
        if (!content) {
            return;
        }

        this._openIndex = index;
        this._lastTrigger = trigger;
        content.hidden = false;
        trigger.setAttribute('aria-expanded', 'true');

        const items = itemsInContent(content, 'menubar');
        if (items.length > 0) {
            applyRovingTabindex(items, 0);
            this._itemIndex = 0;
        }

        bindDocumentClose(this, this._onDocumentKeydown, this._onDocumentClick);
    }

    closeSubmenu(restore = true) {
        if (this._openIndex < 0) {
            return;
        }

        const trigger = this.triggerTargets[this._openIndex];
        const content = this.contentTargets[this._openIndex];
        if (content) {
            content.hidden = true;
        }
        if (trigger) {
            trigger.setAttribute('aria-expanded', 'false');
        }

        this._openIndex = -1;
        unbindDocumentClose(this._onDocumentKeydown, this._onDocumentClick);

        if (restore) {
            restoreFocus(this._lastTrigger);
        }
    }

    _onMenubarKeydown(event) {
        if (this._openIndex >= 0) {
            return;
        }

        const triggers = enabledTriggers(this.triggerTargets);
        if (triggers.length === 0) {
            return;
        }

        const next = rovingKeydown(event, triggers, this._triggerIndex, 'horizontal');
        if (next !== this._triggerIndex) {
            this._triggerIndex = next;
            applyRovingTabindex(triggers, next);
        }

        if (event.key === 'ArrowDown' || event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            const trigger = triggers[this._triggerIndex];
            const index = this.triggerTargets.indexOf(trigger);
            if (index >= 0) {
                this.openSubmenu(index, trigger);
            }
        }
    }

    _onDocumentClick(event) {
        if (!this.element.contains(event.target)) {
            this.closeSubmenu();
        }
    }

    _onDocumentKeydown(event) {
        if (event.key === 'Escape') {
            event.preventDefault();
            this.closeSubmenu();
            return;
        }

        const content = this.contentTargets[this._openIndex];
        if (!content) {
            return;
        }

        const items = itemsInContent(content, 'menubar');
        this._itemIndex = handleSubmenuKeydown(event, content, items, this._itemIndex, 'vertical');
    }
}
