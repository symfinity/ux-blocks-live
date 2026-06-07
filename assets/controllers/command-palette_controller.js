import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['input', 'list', 'item'];

    static values = {
        commandsUrl: String,
        placeholder: { type: String, default: 'Search…' },
        openHotkey: { type: String, default: 'k' },
        fallbackCommands: { type: Array, default: [] },
    };

    connect() {
        this._commands = [];
        this._onKeydown = this._onKeydown.bind(this);
        document.addEventListener('keydown', this._onKeydown);

        if (this.hasInputTarget) {
            this.inputTarget.placeholder = this.placeholderValue;
            this.inputTarget.addEventListener('input', () => this._filter());
        }

        if (this.commandsUrlValue) {
            fetch(this.commandsUrlValue)
                .then((r) => r.json())
                .then((data) => {
                    this._commands = Array.isArray(data.commands) ? data.commands : data;
                    this._renderDynamic();
                })
                .catch(() => {});
        } else if (this.fallbackCommandsValue.length > 0) {
            this._commands = this.fallbackCommandsValue;
            this._renderDynamic();
        }
    }

    disconnect() {
        document.removeEventListener('keydown', this._onKeydown);
    }

    _onKeydown(event) {
        if ((event.metaKey || event.ctrlKey) && event.key === this.openHotkeyValue) {
            event.preventDefault();
            this.element.hidden = !this.element.hidden;
            if (!this.element.hidden && this.hasInputTarget) {
                this.inputTarget.focus();
            }
        }
        if (event.key === 'Escape' && !this.element.hidden) {
            this.element.hidden = true;
        }
    }

    visit(event) {
        const url = event.currentTarget.dataset.url;
        if (url) {
            window.location.href = url;
        }
    }

    _filter() {
        const q = this.hasInputTarget ? this.inputTarget.value.toLowerCase() : '';
        this.itemTargets.forEach((el) => {
            const label = (el.textContent || '').toLowerCase();
            el.hidden = q !== '' && !label.includes(q);
        });
    }

    _renderDynamic() {
        if (!this.hasListTarget || this.itemTargets.length > 0) {
            return;
        }

        this.listTarget.innerHTML = '';
        this._commands.forEach((cmd) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.setAttribute('data-ui-role', 'command-palette-item');
            btn.setAttribute('data-symfony--ux-blocks-live--command-palette-target', 'item');
            btn.textContent = cmd.title || cmd.label || cmd.id || 'Command';
            const url = cmd.url || cmd.handler?.url;
            if (url) {
                btn.addEventListener('click', () => {
                    window.location.href = url;
                });
            }
            this.listTarget.appendChild(btn);
        });
    }
}
