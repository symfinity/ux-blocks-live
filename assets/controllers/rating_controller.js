import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['star', 'input'];

    static values = {
        max: { type: Number, default: 5 },
        value: { type: Number, default: 0 },
    };

    connect() {
        if (this.starTargets.length === 0) {
            for (let i = 1; i <= this.maxValue; i += 1) {
                const button = document.createElement('button');
                button.type = 'button';
                button.textContent = '★';
                button.dataset.value = String(i);
                button.setAttribute('aria-label', `Rate ${i} of ${this.maxValue}`);
                button.setAttribute('data-symfony--ux-blocks-live--rating-target', 'star');
                button.setAttribute(
                    'data-action',
                    'click->symfony--ux-blocks-live--rating#select mouseenter->symfony--ux-blocks-live--rating#preview mouseleave->symfony--ux-blocks-live--rating#clearPreview',
                );
                this.element.appendChild(button);
            }
        }

        this._syncStars(this.valueValue);
    }

    select(event) {
        event.preventDefault();
        const value = Number(event.currentTarget.dataset.value || 0);
        this.valueValue = value;
        this._syncStars(value);
        this._emitChange(value);
    }

    preview(event) {
        const value = Number(event.currentTarget.dataset.value || 0);
        this._syncStars(value, true);
    }

    clearPreview() {
        this._syncStars(this.valueValue);
    }

    valueValueChanged(value) {
        this._syncStars(value);
        if (this.hasInputTarget) {
            this.inputTarget.value = String(value);
        }
        this.element.dataset.value = String(value);
    }

    _syncStars(value, preview = false) {
        this.starTargets.forEach((star) => {
            const starValue = Number(star.dataset.value || 0);
            const filled = starValue <= value;
            star.setAttribute('aria-pressed', filled ? 'true' : 'false');
            star.dataset.state = filled ? 'on' : 'off';
            if (preview) {
                star.dataset.preview = filled ? 'true' : 'false';
            } else {
                star.removeAttribute('data-preview');
            }
        });
    }

    _emitChange(value) {
        this.element.dispatchEvent(
            new CustomEvent('ux-blocks-live:rating-change', {
                bubbles: true,
                detail: { value },
            }),
        );
    }
}
