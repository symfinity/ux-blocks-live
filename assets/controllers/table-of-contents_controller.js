import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['link'];

    static values = {
        scrollTarget: String,
        offset: { type: Number, default: 80 },
        smooth: { type: Boolean, default: true },
    };

    connect() {
        this._scrollRoot = this._resolveScrollRoot();
        if (!this._scrollRoot || this.linkTargets.length === 0) {
            return;
        }

        this._sectionIds = this.linkTargets.map((link) => link.dataset.sectionId).filter(Boolean);
        this._onIntersect = this._handleIntersect.bind(this);
        this._observer = new IntersectionObserver(this._onIntersect, {
            root: this._scrollRoot === document.documentElement ? null : this._scrollRoot,
            rootMargin: `-${this.offsetValue}px 0px -55% 0px`,
            threshold: [0, 0.1, 0.5, 1],
        });

        for (const id of this._sectionIds) {
            const el = document.getElementById(id);
            if (el) {
                this._observer.observe(el);
            }
        }

        this.linkTargets.forEach((link) => {
            link.addEventListener('click', this._onLinkClick);
        });
    }

    disconnect() {
        this._observer?.disconnect();
        this.linkTargets.forEach((link) => {
            link.removeEventListener('click', this._onLinkClick);
        });
    }

    _resolveScrollRoot() {
        const selector = this.scrollTargetValue?.trim();
        if (!selector) {
            return document.documentElement;
        }

        const el = document.querySelector(selector);
        if (!el) {
            return document.documentElement;
        }

        const overflowY = getComputedStyle(el).overflowY;
        if (overflowY === 'auto' || overflowY === 'scroll' || el === document.documentElement) {
            return el;
        }

        return document.documentElement;
    }

    _handleIntersect(entries) {
        const visible = entries
            .filter((e) => e.isIntersecting)
            .sort((a, b) => b.intersectionRatio - a.intersectionRatio);

        if (visible.length === 0) {
            return;
        }

        const id = visible[0].target.id;
        if (id) {
            this._setActive(id);
        }
    }

    _setActive(sectionId) {
        for (const link of this.linkTargets) {
            const active = link.dataset.sectionId === sectionId;
            link.classList.toggle('active', active);
            if (active) {
                link.setAttribute('aria-current', 'true');
            } else {
                link.removeAttribute('aria-current');
            }
        }
    }

    _onLinkClick = (event) => {
        const link = event.currentTarget;
        const id = link.getAttribute('href')?.replace(/^#/, '');
        if (!id) {
            return;
        }

        const target = document.getElementById(id);
        if (!target) {
            return;
        }

        event.preventDefault();
        const behavior = this._scrollBehavior();
        target.scrollIntoView({ behavior, block: 'start' });
        this._setActive(id);
    };

    _scrollBehavior() {
        if (!this.smoothValue) {
            return 'auto';
        }

        return window.matchMedia('(prefers-reduced-motion: reduce)').matches ? 'auto' : 'smooth';
    }
}
