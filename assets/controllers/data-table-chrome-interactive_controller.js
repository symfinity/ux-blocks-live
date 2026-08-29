import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['toolbar', 'pagination', 'body'];

    sort(event) {
        event.preventDefault();
        const th = event.currentTarget;
        const current = th.getAttribute('aria-sort') || 'none';
        const next =
            current === 'none' || current === ''
                ? 'ascending'
                : current === 'ascending'
                  ? 'descending'
                  : 'none';

        this.element.querySelectorAll('[data-sortable]').forEach((header) => {
            if (header !== th) {
                header.removeAttribute('aria-sort');
            }
        });

        if (next === 'none') {
            th.removeAttribute('aria-sort');
        } else {
            th.setAttribute('aria-sort', next);
        }
    }
}
