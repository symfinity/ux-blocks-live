import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['viewport', 'item'];

    next() {
        const vp = this.viewportTarget;
        const item = this.itemTargets[0];
        if (item) {
            vp.scrollBy({ left: item.offsetWidth, behavior: 'smooth' });
        }
    }

    prev() {
        const vp = this.viewportTarget;
        const item = this.itemTargets[0];
        if (item) {
            vp.scrollBy({ left: -item.offsetWidth, behavior: 'smooth' });
        }
    }
}
