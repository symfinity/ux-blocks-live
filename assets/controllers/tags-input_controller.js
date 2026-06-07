import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['chip', 'chipList', 'input', 'hidden'];

    static values = {
        maxTags: Number,
        allowDuplicates: Boolean,
        delimiter: String,
    };

    connect() {
        this._syncHidden();
    }

    keydown(event) {
        if (event.key === 'Enter' || event.key === this.delimiterValue) {
            event.preventDefault();
            this._commitInput();
            return;
        }

        if (event.key === 'Backspace' && this.hasInputTarget && this.inputTarget.value === '') {
            event.preventDefault();
            const chips = this.chipTargets;
            if (chips.length > 0) {
                chips[chips.length - 1].remove();
                this._syncHidden();
            }
        }
    }

    input() {
        if (this.delimiterValue && this.hasInputTarget && this.inputTarget.value.includes(this.delimiterValue)) {
            this._commitInput();
        }
    }

    removeChip(event) {
        event.preventDefault();
        const chip = event.currentTarget.closest('[data-symfony--ux-blocks-live--tags-input-target="chip"]');
        chip?.remove();
        this._syncHidden();
    }

    _commitInput() {
        if (!this.hasInputTarget) {
            return;
        }

        const label = this.inputTarget.value.trim();
        if (label === '') {
            return;
        }

        if (this.hasMaxTagsValue && this.chipTargets.length >= this.maxTagsValue) {
            return;
        }

        if (!this.allowDuplicatesValue) {
            const exists = this.chipTargets.some((chip) => (chip.textContent || '').replace(/×\s*$/, '').trim() === label);
            if (exists) {
                this.inputTarget.value = '';
                return;
            }
        }

        const chip = document.createElement('span');
        chip.setAttribute('role', 'listitem');
        chip.setAttribute('data-ui-role', 'tags-input-chip');
        chip.setAttribute('data-symfony--ux-blocks-live--tags-input-target', 'chip');
        chip.dataset.value = label;
        chip.innerHTML = `${label} <button type="button" aria-label="Remove ${label}" data-action="click->symfony--ux-blocks-live--tags-input#removeChip">×</button>`;

        if (this.hasChipListTarget) {
            this.chipListTarget.appendChild(chip);
        } else {
            this.element.insertBefore(chip, this.inputTarget);
        }

        this.inputTarget.value = '';
        this._syncHidden();

        this.element.dispatchEvent(
            new CustomEvent('ux-blocks-live:tags-input-add', {
                bubbles: true,
                detail: { label },
            }),
        );
    }

    _syncHidden() {
        if (!this.hasHiddenTarget) {
            return;
        }

        const tags = this.chipTargets.map((chip) => ({
            label: (chip.textContent || '').replace(/×\s*$/, '').trim(),
            value: chip.dataset.value || (chip.textContent || '').trim(),
        }));

        this.hiddenTarget.value = JSON.stringify(tags);
    }
}
