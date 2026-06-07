import { Controller } from '@hotwired/stimulus';
import { applyRovingTabindex, rovingKeydown } from './shared/menu-roving.js';

export default class extends Controller {
    static targets = ['list', 'trigger', 'panel'];

    static values = {
        orientation: { type: String, default: 'horizontal' },
        defaultValue: String,
    };

    connect() {
        this._activeIndex = 0;
        this._triggers = this._enabledTriggers();

        const initial = this.defaultValueValue
            || this._triggers[0]?.dataset.value
            || '';

        if (initial) {
            this._activateByValue(initial, false);
        } else if (this._triggers.length > 0) {
            this._activateIndex(0, false);
        }

        this._onKeydown = this._onKeydown.bind(this);
        this.element.addEventListener('keydown', this._onKeydown);
    }

    disconnect() {
        this.element.removeEventListener('keydown', this._onKeydown);
    }

    select(event) {
        const trigger = event.currentTarget;

        if (this._isDisabled(trigger) || trigger.dataset.uiState === 'linked') {
            return;
        }

        const value = trigger.dataset.value;
        if (value) {
            this._activateByValue(value, true);
        }
    }

    _onKeydown(event) {
        if (!this.hasListTarget) {
            return;
        }

        const items = this._enabledTriggers();
        if (items.length === 0) {
            return;
        }

        const current = items.indexOf(this.triggerTargets[this._activeIndex]);
        const activeInEnabled = current >= 0 ? current : 0;
        const next = rovingKeydown(event, items, activeInEnabled, this.orientationValue);

        if (next !== activeInEnabled) {
            const value = items[next]?.dataset.value;
            if (value) {
                this._activateByValue(value, true);
            }
        }
    }

    _activateByValue(value, focus) {
        const index = this.triggerTargets.findIndex((el) => el.dataset.value === value);
        if (index >= 0) {
            this._activateIndex(index, focus);
        }
    }

    _activateIndex(index, focus) {
        const trigger = this.triggerTargets[index];
        if (!trigger || this._isDisabled(trigger) || trigger.dataset.uiState === 'linked') {
            return;
        }

        this._activeIndex = index;
        this._triggers = this._enabledTriggers();
        applyRovingTabindex(this.triggerTargets, index);

        const activeValue = trigger.dataset.value;
        this._panels.forEach((panel) => {
            const match = panel.dataset.value === activeValue;
            panel.hidden = !match;
            panel.setAttribute('aria-hidden', match ? 'false' : 'true');
        });

        this.triggerTargets.forEach((item, i) => {
            const selected = i === index;
            item.setAttribute('aria-selected', selected ? 'true' : 'false');
            item.tabIndex = selected ? 0 : -1;
        });

        if (focus) {
            trigger.focus();
        }
    }

    _enabledTriggers() {
        return this.triggerTargets.filter((trigger) => !this._isDisabled(trigger) && trigger.dataset.uiState !== 'linked');
    }

    _isDisabled(trigger) {
        return trigger.disabled === true || trigger.getAttribute('aria-disabled') === 'true';
    }
}
