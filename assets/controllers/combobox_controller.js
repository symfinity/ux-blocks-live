import { Controller } from '@hotwired/stimulus';
import { applyRovingTabindex, rovingKeydown } from './shared/menu-roving.js';
import { restoreFocus, trapFocus } from './shared/overlay-base.js';

export default class extends Controller {
    static targets = ['trigger', 'content', 'item', 'filter'];

    static values = {
        creatable: Boolean,
        preventDuplicates: { type: Boolean, default: true },
        onCreate: String,
    };

    connect() {
        this._open = false;
        this._activeIndex = 0;
        this._onDocumentKeydown = this._onDocumentKeydown.bind(this);
        this._onDocumentClick = this._onDocumentClick.bind(this);

        if (this.hasTriggerTarget) {
            this.triggerTarget.setAttribute('role', 'combobox');
            this.triggerTarget.setAttribute('aria-haspopup', 'listbox');
            this.triggerTarget.setAttribute('aria-expanded', 'false');
        }
        if (this.hasContentTarget) {
            this.contentTarget.setAttribute('role', 'listbox');
            if (!this.contentTarget.id) {
                this.contentTarget.id = `combobox-listbox-${Math.random().toString(36).slice(2, 9)}`;
            }
        }
        if (this.hasTriggerTarget && this.hasContentTarget) {
            this.triggerTarget.setAttribute('aria-controls', this.contentTarget.id);
        }
        this._syncActiveDescendant();
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

    filter() {
        const query = this.hasFilterTarget
            ? this.filterTarget.value.trim().toLowerCase()
            : '';

        this.itemTargets.forEach((item) => {
            const label = (item.textContent || '').trim().toLowerCase();
            const match = query === '' || label.includes(query);
            item.hidden = !match;
            item.setAttribute('aria-hidden', match ? 'false' : 'true');
        });

        const visible = this._visibleItems();
        this._activeIndex = 0;
        if (visible.length > 0) {
            applyRovingTabindex(visible, 0);
            this._syncActiveDescendant();
        }
    }

    selectItem(event) {
        event.preventDefault();
        const item = event.currentTarget;
        if (item.disabled || item.hidden) {
            return;
        }

        if (this.hasTriggerTarget) {
            const label = (item.textContent || '').trim();
            if (label) {
                this.triggerTarget.textContent = label;
            }
            const value = item.dataset.value || label;
            this.triggerTarget.dataset.value = value;
        }

        this.itemTargets.forEach((el) => {
            el.setAttribute('aria-selected', el === item ? 'true' : 'false');
        });

        this.close();
    }

    open(trigger = this.triggerTarget) {
        if (!this.hasContentTarget) {
            return;
        }

        this._open = true;
        this._lastTrigger = trigger;
        this.contentTarget.hidden = false;
        trigger.setAttribute('aria-expanded', 'true');

        const items = this._visibleItems();
        if (items.length > 0) {
            applyRovingTabindex(items, 0);
            this._activeIndex = 0;
            this._syncActiveDescendant();
        }

        if (this.hasFilterTarget) {
            this.filterTarget.focus();
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
            this.triggerTarget.removeAttribute('aria-activedescendant');
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

        const items = this._visibleItems();
        const next = rovingKeydown(event, items, this._activeIndex, 'vertical');
        if (next !== this._activeIndex) {
            this._activeIndex = next;
            applyRovingTabindex(items, next);
            this._syncActiveDescendant();
        }

        if (event.key === 'Enter' && items[this._activeIndex]) {
            event.preventDefault();
            items[this._activeIndex].click();
            return;
        }

        if (event.key === 'Enter' && this.creatableValue && this.hasFilterTarget) {
            event.preventDefault();
            this._commitCreatable(this.filterTarget.value.trim());
        }
    }

    _visibleItems() {
        return this.itemTargets.filter((el) => !el.disabled && !el.hidden);
    }

    _commitCreatable(label) {
        if (label === '') {
            return;
        }

        if (this.preventDuplicatesValue) {
            const exists = this.itemTargets.some((item) => (item.textContent || '').trim().toLowerCase() === label.toLowerCase());
            if (exists) {
                return;
            }
        }

        if (this.hasTriggerTarget) {
            this.triggerTarget.textContent = label;
            this.triggerTarget.dataset.value = label;
        }

        this.element.dispatchEvent(
            new CustomEvent('ux-blocks-live:combobox-create', {
                bubbles: true,
                detail: { label, value: label },
            }),
        );

        this.close();
    }

    _syncActiveDescendant() {
        if (!this.hasTriggerTarget) {
            return;
        }

        const items = this._visibleItems();
        const active = items[this._activeIndex];
        if (active?.id) {
            this.triggerTarget.setAttribute('aria-activedescendant', active.id);
        } else if (active) {
            if (!active.id) {
                active.id = `combobox-option-${Math.random().toString(36).slice(2, 9)}`;
            }
            this.triggerTarget.setAttribute('aria-activedescendant', active.id);
        }
    }
}
