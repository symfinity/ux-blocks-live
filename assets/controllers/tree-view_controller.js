import { Controller } from '@hotwired/stimulus';
import { applyRovingTabindex, rovingKeydown } from './shared/menu-roving.js';

export default class extends Controller {
    static targets = ['item'];

    static values = {
        selectable: Boolean,
    };

    connect() {
        this._activeIndex = 0;
        this._applyRoving();
    }

    activate(event) {
        const item = event.currentTarget;
        const group = item.querySelector('[role="group"]');

        if (group) {
            const expanded = item.getAttribute('aria-expanded') === 'true';
            item.setAttribute('aria-expanded', expanded ? 'false' : 'true');
            group.hidden = expanded;
            event.stopPropagation();
            return;
        }

        if (this.selectableValue) {
            this.itemTargets.forEach((el) => {
                el.setAttribute('aria-selected', el === item ? 'true' : 'false');
            });

            this.element.dispatchEvent(
                new CustomEvent('ux-blocks-live:tree-view-select', {
                    bubbles: true,
                    detail: { id: item.dataset.nodeId },
                }),
            );
        }
    }

    keydown(event) {
        const items = this.itemTargets.filter((el) => !el.hasAttribute('aria-disabled'));
        if (items.length === 0) {
            return;
        }

        const orientation = event.key === 'ArrowLeft' || event.key === 'ArrowRight' ? 'horizontal' : 'vertical';
        const next = rovingKeydown(event, items, this._activeIndex, orientation);
        if (next !== this._activeIndex) {
            this._activeIndex = next;
            this._applyRoving();
            return;
        }

        if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            event.currentTarget.click();
        }
    }

    _applyRoving() {
        const items = this.itemTargets.filter((el) => !el.hasAttribute('aria-disabled'));
        if (items.length > 0) {
            applyRovingTabindex(items, this._activeIndex);
        }
    }
}
