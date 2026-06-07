import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['input', 'hidden'];

    static values = { length: { type: Number, default: 6 } };

    connect() {
        if (!this.hasInputTarget) {
            const n = this.lengthValue;
            for (let i = 0; i < n; i += 1) {
                const input = document.createElement('input');
                input.type = 'text';
                input.inputMode = 'numeric';
                input.maxLength = 1;
                input.autocomplete = 'one-time-code';
                input.setAttribute('aria-label', `Digit ${i + 1} of ${n}`);
                input.setAttribute('data-symfony--ux-blocks-live--input-otp-target', 'input');
                input.setAttribute(
                    'data-action',
                    'input->symfony--ux-blocks-live--input-otp#onInput keydown->symfony--ux-blocks-live--input-otp#onKeydown paste->symfony--ux-blocks-live--input-otp#onPaste',
                );
                this.element.appendChild(input);
            }
        }

        this.element.addEventListener('paste', this._onPaste.bind(this));
        this._syncHidden();
    }

    disconnect() {
        this.element.removeEventListener('paste', this._onPaste);
    }

    onInput(event) {
        const input = event.target;
        const index = this.inputTargets.indexOf(input);
        const digit = input.value.replace(/\D/g, '').slice(-1);
        input.value = digit;

        if (digit.length === 1 && this.inputTargets[index + 1]) {
            this.inputTargets[index + 1].focus();
        }

        this._syncHidden();
    }

    onKeydown(event) {
        const input = event.target;
        const index = this.inputTargets.indexOf(input);

        if (event.key === 'Backspace' && input.value === '' && index > 0) {
            event.preventDefault();
            const prev = this.inputTargets[index - 1];
            prev.focus();
            prev.value = '';
            this._syncHidden();
        }
    }

    onPaste(event) {
        this._fillFromString(event.clipboardData?.getData('text') || '');
        event.preventDefault();
    }

    _onPaste(event) {
        if (event.target !== this.element && !this.element.contains(event.target)) {
            return;
        }
        this._fillFromString(event.clipboardData?.getData('text') || '');
        event.preventDefault();
    }

    _fillFromString(raw) {
        const digits = raw.replace(/\D/g, '').slice(0, this.lengthValue).split('');
        this.inputTargets.forEach((input, i) => {
            input.value = digits[i] || '';
        });
        const next = this.inputTargets[Math.min(digits.length, this.inputTargets.length - 1)];
        next?.focus();
        this._syncHidden();
    }

    _syncHidden() {
        const code = this.inputTargets.map((el) => el.value).join('');
        this.element.dataset.value = code;

        if (this.hasHiddenTarget) {
            this.hiddenTarget.value = code;
        }

        if (code.length === this.lengthValue) {
            this.element.dispatchEvent(
                new CustomEvent('ux-blocks-live:input-otp-complete', {
                    bubbles: true,
                    detail: { code },
                }),
            );
        }
    }
}
