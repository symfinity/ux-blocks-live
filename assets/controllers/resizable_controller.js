import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['handle', 'panel'];

    connect() {
        if (this.hasHandleTarget) {
            this.handleTarget.addEventListener('mousedown', (e) => this._start(e));
        }
    }

    _start(event) {
        event.preventDefault();
        const startX = event.clientX;
        const startWidth = this.panelTargets[0]?.offsetWidth ?? 0;
        const onMove = (e) => {
            const delta = e.clientX - startX;
            if (this.panelTargets[0]) {
                this.panelTargets[0].style.flexBasis = `${Math.max(120, startWidth + delta)}px`;
            }
        };
        const onUp = () => {
            document.removeEventListener('mousemove', onMove);
            document.removeEventListener('mouseup', onUp);
        };
        document.addEventListener('mousemove', onMove);
        document.addEventListener('mouseup', onUp);
    }
}
