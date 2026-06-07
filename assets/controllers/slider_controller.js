import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['track', 'input', 'output'];

    static values = {
        min: { type: Number, default: 0 },
        max: { type: Number, default: 100 },
        step: { type: Number, default: 1 },
    };

    connect() {
        if (!this.hasInputTarget) {
            const input = document.createElement('input');
            input.type = 'range';
            input.min = String(this.minValue);
            input.max = String(this.maxValue);
            input.step = String(this.stepValue);
            input.value = String(this.minValue);
            input.setAttribute('data-symfony--ux-blocks-live--slider-target', 'input');
            input.setAttribute(
                'data-action',
                'input->symfony--ux-blocks-live--slider#syncValue change->symfony--ux-blocks-live--slider#syncValue keydown->symfony--ux-blocks-live--slider#keydown',
            );
            this.element.appendChild(input);
        } else {
            this._ensureRangeAttrs(this.inputTarget);
        }

        this.syncValue();
    }

    syncValue() {
        if (!this.hasInputTarget) {
            return;
        }

        const value = this.inputTarget.value;
        this.element.dataset.value = value;
        this.element.dispatchEvent(
            new CustomEvent('ux-blocks-live:slider-change', {
                bubbles: true,
                detail: { value: Number(value) },
            }),
        );

        if (this.hasOutputTarget) {
            this.outputTarget.textContent = value;
        }
    }

    keydown(event) {
        if (!this.hasInputTarget) {
            return;
        }

        const step = this.stepValue;
        const current = Number(this.inputTarget.value);
        const min = this.minValue;
        const max = this.maxValue;

        if (event.key === 'ArrowLeft' || event.key === 'ArrowDown') {
            event.preventDefault();
            this.inputTarget.value = String(Math.max(min, current - step));
            this.syncValue();
        } else if (event.key === 'ArrowRight' || event.key === 'ArrowUp') {
            event.preventDefault();
            this.inputTarget.value = String(Math.min(max, current + step));
            this.syncValue();
        }
    }

    _ensureRangeAttrs(input) {
        input.min = input.min || String(this.minValue);
        input.max = input.max || String(this.maxValue);
        input.step = input.step || String(this.stepValue);
    }
}
