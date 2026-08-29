import { Controller } from '@hotwired/stimulus';
import { restoreFocus, trapFocus } from './shared/overlay-base.js';
import { parseIsoDate } from './shared/calendar-range.js';

export default class extends Controller {
    static targets = ['startSegment', 'endSegment', 'content'];

    connect() {
        this._open = false;
        this._activeSegment = 'start';
        this._onDocumentKeydown = this._onDocumentKeydown.bind(this);
        this._onDocumentClick = this._onDocumentClick.bind(this);
        this._onCalendarSelect = this._onCalendarSelect.bind(this);

        this.element.addEventListener('ux-blocks-live:calendar-select', this._onCalendarSelect);

        this._segmentTargets().forEach((input) => {
            input.setAttribute('aria-haspopup', 'dialog');
            input.setAttribute('aria-expanded', 'false');
            if (this.hasContentTarget && this.contentTarget.id) {
                input.setAttribute('aria-controls', this.contentTarget.id);
            }
        });
    }

    disconnect() {
        this.close();
        document.removeEventListener('keydown', this._onDocumentKeydown);
        document.removeEventListener('click', this._onDocumentClick);
        this.element.removeEventListener('ux-blocks-live:calendar-select', this._onCalendarSelect);
    }

    focusSegment(event) {
        this._activeSegment = event.currentTarget.dataset.segment === 'end' ? 'end' : 'start';
    }

    open(event) {
        event.preventDefault();
        this.focusSegment(event);
        if (this._open) {
            return;
        }

        if (!this.hasContentTarget) {
            return;
        }

        this._open = true;
        this._lastTrigger = event.currentTarget;
        this.contentTarget.hidden = false;
        this._segmentTargets().forEach((input) => {
            input.setAttribute('aria-expanded', 'true');
        });

        document.addEventListener('keydown', this._onDocumentKeydown);
        document.addEventListener('click', this._onDocumentClick);

        const focusable = this.contentTarget.querySelector('button, input');
        focusable?.focus();
    }

    close() {
        if (!this._open) {
            return;
        }

        this._open = false;
        if (this.hasContentTarget) {
            this.contentTarget.hidden = true;
        }
        this._segmentTargets().forEach((input) => {
            input.setAttribute('aria-expanded', 'false');
        });

        document.removeEventListener('keydown', this._onDocumentKeydown);
        document.removeEventListener('click', this._onDocumentClick);
        restoreFocus(this._lastTrigger);
    }

    _onCalendarSelect(event) {
        const date = event.detail?.date;
        if (!date) {
            return;
        }

        const target = this._activeSegment === 'end' && this.hasEndSegmentTarget
            ? this.endSegmentTarget
            : this.startSegmentTarget;

        if (target) {
            target.value = date;
            target.dataset.value = date;
        }

        if (this._activeSegment === 'start' && this.hasEndSegmentTarget) {
            this._activeSegment = 'end';
            this.endSegmentTarget.focus();
            return;
        }

        this._validateRange();
        this.element.dispatchEvent(
            new CustomEvent('ux-blocks-live:date-range-picker-change', {
                bubbles: true,
                detail: {
                    start: this.hasStartSegmentTarget ? this.startSegmentTarget.value : null,
                    end: this.hasEndSegmentTarget ? this.endSegmentTarget.value : null,
                },
            }),
        );

        this.close();
    }

    _validateRange() {
        if (!this.hasStartSegmentTarget || !this.hasEndSegmentTarget) {
            return;
        }

        const start = parseIsoDate(this.startSegmentTarget.value);
        const end = parseIsoDate(this.endSegmentTarget.value);
        const invalid = start && end && end < start;

        this.startSegmentTarget.toggleAttribute('aria-invalid', Boolean(invalid));
        this.endSegmentTarget.toggleAttribute('aria-invalid', Boolean(invalid));
    }

    _onDocumentClick(event) {
        if (!this.element.contains(event.target)) {
            this.close();
        }
    }

    _onDocumentKeydown(event) {
        if (event.key === 'Escape') {
            event.preventDefault();
            this.close();
            return;
        }

        if (!this._open || !this.hasContentTarget) {
            return;
        }

        trapFocus(this.contentTarget, event);
    }

    _segmentTargets() {
        return [this.hasStartSegmentTarget ? this.startSegmentTarget : null, this.hasEndSegmentTarget ? this.endSegmentTarget : null]
            .filter(Boolean);
    }
}
