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
    static targets = ['trigger', 'content', 'item', 'viewport'];

    connect() {
        this._openIndex = -1;
        this._triggerIndex = 0;
        this._itemIndex = 0;
        this._lastTrigger = null;
        this._onDocumentKeydown = this._onDocumentKeydown.bind(this);
        this._onDocumentClick = this._onDocumentClick.bind(this);
        this._onNavKeydown = this._onNavKeydown.bind(this);

        hideAllContents(this.contentTargets);
        collapseTriggers(this.triggerTargets);

        const triggers = enabledTriggers(this.triggerTargets);
        if (triggers.length > 0) {
            applyRovingTabindex(triggers, 0);
            this._triggerIndex = 0;
        }

        this.element.addEventListener('keydown', this._onNavKeydown);
    }

    disconnect() {
        this.closePanel(false);
        this.element.removeEventListener('keydown', this._onNavKeydown);
        unbindDocumentClose(this._onDocumentKeydown, this._onDocumentClick);
    }

    open(event) {
        event.preventDefault();
        event.stopPropagation();

        const trigger = event.currentTarget;
        const index = this.triggerTargets.indexOf(trigger);
        if (index < 0) {
            return;
        }

        if (this._openIndex === index) {
            this.closePanel();
        } else {
            this.showPanel(index, trigger);
        }
    }

    showPanel(index, trigger) {
        hideAllContents(this.contentTargets);
        collapseTriggers(this.triggerTargets);

        const content = this.contentTargets[index];
        if (!content) {
            return;
        }

        this._openIndex = index;
        this._lastTrigger = trigger;
        content.hidden = false;
        trigger.setAttribute('aria-expanded', 'true');

        if (this.hasViewportTarget) {
            this.viewportTarget.hidden = false;
        }

        const items = itemsInContent(content, 'navigation-menu');
        if (items.length > 0) {
            applyRovingTabindex(items, 0);
            this._itemIndex = 0;
        }

        bindDocumentClose(this, this._onDocumentKeydown, this._onDocumentClick);
    }

    closePanel(restore = true) {
        if (this._openIndex < 0) {
            return;
        }

        hideAllContents(this.contentTargets);
        collapseTriggers(this.triggerTargets);

        if (this.hasViewportTarget) {
            this.viewportTarget.hidden = true;
        }

        this._openIndex = -1;
        unbindDocumentClose(this._onDocumentKeydown, this._onDocumentClick);

        if (restore) {
            restoreFocus(this._lastTrigger);
        }
    }

    _onNavKeydown(event) {
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
                this.showPanel(index, trigger);
            }
        }
    }

    _onDocumentClick(event) {
        if (!this.element.contains(event.target)) {
            this.closePanel();
        }
    }

    _onDocumentKeydown(event) {
        if (event.key === 'Escape') {
            event.preventDefault();
            this.closePanel();
            return;
        }

        const content = this.contentTargets[this._openIndex];
        if (!content) {
            return;
        }

        const items = itemsInContent(content, 'navigation-menu');
        this._itemIndex = handleSubmenuKeydown(event, content, items, this._itemIndex, 'vertical');
    }
}
