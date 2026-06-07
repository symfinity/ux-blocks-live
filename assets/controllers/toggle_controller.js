import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static values = {
        pressed: { type: Boolean, default: false },
    };

    connect() {
        this._syncPressed(this.pressedValue);
    }

    toggle(event) {
        event.preventDefault();
        this.pressedValue = !this.pressedValue;
        this._syncPressed(this.pressedValue);
        this.element.dispatchEvent(
            new CustomEvent('ux-blocks-live:toggle-change', {
                bubbles: true,
                detail: { pressed: this.pressedValue },
            }),
        );
    }

    pressedValueChanged(value) {
        this._syncPressed(value);
    }

    _syncPressed(pressed) {
        this.element.setAttribute('aria-pressed', pressed ? 'true' : 'false');
        this.element.dataset.state = pressed ? 'on' : 'off';
    }
}
