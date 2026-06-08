import { Controller } from '@hotwired/stimulus';
import { getComponent } from '@symfony/ux-live-component';

export default class extends Controller {
    static values = {
        delimiter: String,
    };

    async keydown(event) {
        const input = event.currentTarget;
        if (!(input instanceof HTMLInputElement)) {
            return;
        }

        if (event.key === this.delimiterValue) {
            event.preventDefault();
            await this._commitInput(input);

            return;
        }

        if (event.key === 'Backspace' && input.value === '') {
            event.preventDefault();
            const component = await getComponent(this.element);
            await component.action('removeLastTag');
        }
    }

    async input(event) {
        const input = event.currentTarget;
        if (!(input instanceof HTMLInputElement)) {
            return;
        }

        if (this.delimiterValue && input.value.includes(this.delimiterValue)) {
            await this._commitInput(input);
        }
    }

    async _commitInput(input) {
        const label = input.value.trim();
        if ('' === label) {
            return;
        }

        const component = await getComponent(this.element);
        await component.action('addTag', { label });
    }
}
