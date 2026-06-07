import { Controller } from '@hotwired/stimulus';
import { applyRovingTabindex, rovingKeydown } from './shared/menu-roving.js';

export default class extends Controller {
    static targets = ['item'];

    static values = {
        mode: { type: String, default: 'single' },
        orientation: { type: String, default: 'horizontal' },
    };

    connect() {
        this._activeIndex = 0;
        const items = this.itemTargets;
        if (items.length > 0) {
            applyRovingTabindex(items, 0);
            items.forEach((el) => {
                if (!el.hasAttribute('aria-pressed')) {
                    el.setAttribute('aria-pressed', 'false');
                }
            });
        }

        this._onKeydown = this._onKeydown.bind(this);
        this.element.addEventListener('keydown', this._onKeydown);
        this.element.setAttribute('role', 'group');
    }

    disconnect() {
        this.element.removeEventListener('keydown', this._onKeydown);
    }

    select(event) {
        event.preventDefault();
        const item = event.currentTarget;
        const index = this.itemTargets.indexOf(item);
        if (index < 0) {
            return;
        }

        if (this.modeValue === 'single') {
            this.itemTargets.forEach((el, i) => {
                const on = i === index;
                el.setAttribute('aria-pressed', on ? 'true' : 'false');
                el.dataset.state = on ? 'on' : 'off';
            });
        } else {
            const pressed = item.getAttribute('aria-pressed') !== 'true';
            item.setAttribute('aria-pressed', pressed ? 'true' : 'false');
            item.dataset.state = pressed ? 'on' : 'off';
        }

        this._activeIndex = index;
        applyRovingTabindex(this.itemTargets, index);

        this.element.dispatchEvent(
            new CustomEvent('ux-blocks-live:toggle-group-change', {
                bubbles: true,
                detail: { value: this._selectedValues() },
            }),
        );
    }

    _onKeydown(event) {
        const items = this.itemTargets;
        if (items.length === 0) {
            return;
        }

        const next = rovingKeydown(event, items, this._activeIndex, this.orientationValue);
        if (next !== this._activeIndex) {
            this._activeIndex = next;
            applyRovingTabindex(items, next);
        }
    }

    _selectedValues() {
        return this.itemTargets
            .filter((el) => el.getAttribute('aria-pressed') === 'true')
            .map((el) => el.dataset.value || (el.textContent || '').trim());
    }
}
