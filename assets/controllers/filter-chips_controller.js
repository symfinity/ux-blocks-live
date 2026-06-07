import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['chip', 'input'];

    connect() {
        this.element.setAttribute('role', 'list');
    }

    removeChip(event) {
        event.preventDefault();
        event.stopPropagation();

        const button = event.currentTarget;
        const chip = button.closest('[data-symfony--ux-blocks-live--filter-chips-target="chip"]')
            || button.parentElement;

        if (!chip) {
            return;
        }

        const label = (chip.textContent || '').replace(/×\s*$/, '').trim();
        chip.remove();

        this.element.dispatchEvent(
            new CustomEvent('ux-blocks-live:filter-chips-remove', {
                bubbles: true,
                detail: { label },
            }),
        );
    }
}
