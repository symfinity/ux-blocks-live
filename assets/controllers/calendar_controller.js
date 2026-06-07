import { Controller } from '@hotwired/stimulus';
import { applyRovingTabindex, rovingKeydown } from './shared/menu-roving.js';

export default class extends Controller {
    static targets = ['grid', 'label', 'day'];

    static values = {
        month: { type: Number, default: 0 },
        year: { type: Number, default: 0 },
    };

    connect() {
        const now = new Date();
        if (!this.monthValue) {
            this.monthValue = now.getMonth();
        }
        if (!this.yearValue) {
            this.yearValue = now.getFullYear();
        }

        this._activeIndex = 0;
        this._renderMonth();
        this._onKeydown = this._onKeydown.bind(this);
        if (this.hasGridTarget) {
            this.gridTarget.addEventListener('keydown', this._onKeydown);
        }
    }

    disconnect() {
        if (this.hasGridTarget) {
            this.gridTarget.removeEventListener('keydown', this._onKeydown);
        }
    }

    previousMonth() {
        if (this.monthValue <= 0) {
            this.monthValue = 11;
            this.yearValue -= 1;
        } else {
            this.monthValue -= 1;
        }
        this._renderMonth();
    }

    nextMonth() {
        if (this.monthValue >= 11) {
            this.monthValue = 0;
            this.yearValue += 1;
        } else {
            this.monthValue += 1;
        }
        this._renderMonth();
    }

    selectDay(event) {
        event.preventDefault();
        const button = event.currentTarget;
        const iso = button.dataset.date;
        if (!iso) {
            return;
        }

        this.dayTargets.forEach((el) => {
            el.setAttribute('aria-selected', el === button ? 'true' : 'false');
        });

        this.element.dispatchEvent(
            new CustomEvent('ux-blocks-live:calendar-select', {
                bubbles: true,
                detail: { date: iso },
            }),
        );
    }

    _onKeydown(event) {
        const days = this.dayTargets.filter((el) => !el.disabled);
        if (days.length === 0) {
            return;
        }

        const next = rovingKeydown(event, days, this._activeIndex, 'horizontal');
        if (next !== this._activeIndex) {
            this._activeIndex = next;
            applyRovingTabindex(days, next);
        }
    }

    _renderMonth() {
        if (!this.hasGridTarget) {
            return;
        }

        const month = this.monthValue;
        const year = this.yearValue;
        const first = new Date(year, month, 1);
        const startOffset = (first.getDay() + 6) % 7;
        const daysInMonth = new Date(year, month + 1, 0).getDate();

        if (this.hasLabelTarget) {
            this.labelTarget.textContent = first.toLocaleDateString(undefined, {
                month: 'long',
                year: 'numeric',
            });
        }

        this.gridTarget.innerHTML = '';
        this.gridTarget.setAttribute('role', 'grid');
        this.gridTarget.setAttribute('aria-label', this.labelTarget?.textContent || 'Calendar');

        const weekdays = ['Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa', 'Su'];
        const head = document.createElement('div');
        head.setAttribute('role', 'row');
        weekdays.forEach((name) => {
            const cell = document.createElement('div');
            cell.setAttribute('role', 'columnheader');
            cell.textContent = name;
            head.appendChild(cell);
        });
        this.gridTarget.appendChild(head);

        let row = document.createElement('div');
        row.setAttribute('role', 'row');

        for (let i = 0; i < startOffset; i += 1) {
            const pad = document.createElement('div');
            pad.setAttribute('role', 'gridcell');
            pad.setAttribute('aria-hidden', 'true');
            row.appendChild(pad);
        }

        const dayButtons = [];

        for (let day = 1; day <= daysInMonth; day += 1) {
            if (row.children.length >= 7) {
                this.gridTarget.appendChild(row);
                row = document.createElement('div');
                row.setAttribute('role', 'row');
            }

            const iso = `${year}-${String(month + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            const button = document.createElement('button');
            button.type = 'button';
            button.setAttribute('role', 'gridcell');
            button.setAttribute('aria-selected', 'false');
            button.dataset.date = iso;
            button.textContent = String(day);
            button.setAttribute('data-symfony--ux-blocks-live--calendar-target', 'day');
            button.setAttribute(
                'data-action',
                'click->symfony--ux-blocks-live--calendar#selectDay',
            );
            row.appendChild(button);
            dayButtons.push(button);
        }

        this.gridTarget.appendChild(row);

        if (dayButtons.length > 0) {
            this._activeIndex = 0;
            dayButtons.forEach((btn, index) => {
                btn.tabIndex = index === 0 ? 0 : -1;
            });
        }
    }
}
