import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['item'];

    show(event) {
        const message =
            event.params?.message ||
            event.currentTarget?.dataset?.toastMessage ||
            'Notification';
        const el = document.createElement('div');
        el.setAttribute('data-ui-role', 'toast-item');
        el.setAttribute('data-symfony--ux-blocks-live--toast-target', 'item');
        el.setAttribute('role', 'status');
        el.textContent = message;
        this.element.appendChild(el);
        window.setTimeout(() => el.remove(), 4000);
    }
}
