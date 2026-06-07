import { Controller } from '@hotwired/stimulus';
import { applyRovingTabindex, rovingKeydown } from './shared/menu-roving.js';

export default class extends Controller {
    static targets = ['navToggle', 'nav', 'navItem', 'panel'];

    static values = {
        defaultPanel: { type: String, default: '' },
    };

    connect() {
        this._navOpen = false;
        this._navIndex = 0;
        this._onNavKeydown = this._onNavKeydown.bind(this);

        const initial = this.defaultPanelValue
            || this.navItemTargets[0]?.dataset.panel
            || '';

        if (initial) {
            this._activatePanel(initial, false);
        }

        if (this.hasNavTarget) {
            this.navTarget.addEventListener('keydown', this._onNavKeydown);
        }
    }

    disconnect() {
        if (this.hasNavTarget) {
            this.navTarget.removeEventListener('keydown', this._onNavKeydown);
        }
    }

    selectPanel(event) {
        event.preventDefault();
        const panelId = event.currentTarget.dataset.panel;
        if (panelId) {
            this._activatePanel(panelId, true);
        }

        if (window.matchMedia('(max-width: 768px)').matches) {
            this._setNavOpen(false);
        }
    }

    toggleNav(event) {
        event?.preventDefault();
        this._setNavOpen(!this._navOpen);
    }

    _activatePanel(panelId, focus) {
        this.panelTargets.forEach((panel) => {
            const match = panel.dataset.panel === panelId;
            panel.hidden = !match;
            panel.setAttribute('aria-hidden', match ? 'false' : 'true');
        });

        this.navItemTargets.forEach((item, index) => {
            const selected = item.dataset.panel === panelId;
            item.setAttribute('aria-current', selected ? 'page' : 'false');
            if (selected) {
                this._navIndex = index;
            }
        });

        applyRovingTabindex(this.navItemTargets, this._navIndex);

        if (focus) {
            this.navItemTargets[this._navIndex]?.focus();
        }
    }

    _setNavOpen(open) {
        this._navOpen = open;
        if (this.hasNavTarget) {
            this.navTarget.hidden = !open;
            this.navTarget.setAttribute('aria-hidden', open ? 'false' : 'true');
        }
        if (this.hasNavToggleTarget) {
            this.navToggleTarget.setAttribute('aria-expanded', open ? 'true' : 'false');
        }
    }

    _onNavKeydown(event) {
        const items = this.navItemTargets;
        const next = rovingKeydown(event, items, this._navIndex, 'vertical');
        if (next !== this._navIndex) {
            this._navIndex = next;
            applyRovingTabindex(items, next);
        }

        if (event.key === 'Enter' || event.key === ' ') {
            event.preventDefault();
            const panelId = items[this._navIndex]?.dataset.panel;
            if (panelId) {
                this._activatePanel(panelId, true);
            }
        }
    }
}
