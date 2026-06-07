<?php

declare(strict_types=1);

/**
 * One-shot scaffold for symfinity 025 remaining roles (T025–T047).
 * Run from package root: php bin/scaffold-remaining-roles.php
 */

$root = dirname(__DIR__);
$src = $root . '/src/Twig/Components';
$tpl = $root . '/templates/components';
$js = $root . '/assets/controllers';

function writeFile(string $path, string $content): void
{
    $dir = dirname($path);
    if (!is_dir($dir)) {
        mkdir($dir, 0775, true);
    }
    if (!is_file($path)) {
        file_put_contents($path, $content);
        echo "created {$path}\n";
    }
}

function phpClass(string $name, string $twigName, string $template): string
{
    return <<<PHP
<?php

declare(strict_types=1);

namespace Symfinity\\UxBlocksExtended\\Twig\\Components;

use Symfony\\UX\\TwigComponent\\Attribute\\AsTwigComponent;

#[AsTwigComponent('{$twigName}', template: '{$template}')]
final class {$name}
{
}

PHP;
}

function phpClassWithProps(string $name, string $twigName, string $template, string $props): string
{
    return <<<PHP
<?php

declare(strict_types=1);

namespace Symfinity\\UxBlocksExtended\\Twig\\Components;

use Symfony\\UX\\TwigComponent\\Attribute\\AsTwigComponent;

#[AsTwigComponent('{$twigName}', template: '{$template}')]
final class {$name}
{
{$props}
}

PHP;
}

/** @param list<string> $nested */
function scaffoldMenu(string $role, string $component, string $controllerSlug, array $nested = ['Trigger', 'Content', 'Item']): void
{
    global $src, $tpl, $js;

    $kebab = $role;
    $ctrl = 'symfony--ux-blocks-live--' . $controllerSlug;

    writeFile(
        "{$src}/{$component}.php",
        phpClass($component, $component, "@UxBlocksLive/components/{$component}.html.twig"),
    );
    writeFile(
        "{$tpl}/{$component}.html.twig",
        <<<TWIG
<div
    data-ui-role="{$kebab}"
    data-ui-fragment="blocks.live.{$kebab}"
    data-controller="{$ctrl}"
    {{ attributes }}
>
    {% block content %}{% endblock %}
</div>

TWIG,
    );

    foreach ($nested as $part) {
        $partKebab = strtolower(preg_replace('/([a-z])([A-Z])/', '$1-$2', $part) ?? $part);
        $partKebab = str_replace('_', '-', $partKebab);
        $subRole = "{$kebab}-{$partKebab}";
        $target = lcfirst($part);
        $class = $component . $part;
        $twigPart = "{$component}:{$part}";

        writeFile(
            "{$src}/{$class}.php",
            phpClass($class, $twigPart, "@UxBlocksLive/components/{$component}/{$part}.html.twig"),
        );

        if ($part === 'Trigger') {
            $inner = <<<TWIG
<button
    type="button"
    aria-haspopup="menu"
    aria-expanded="false"
    data-ui-role="{$subRole}"
    data-{$ctrl}-target="trigger"
    {{ attributes }}
>
    {% block content %}{% endblock %}
</button>

TWIG;
        } elseif ($part === 'Content') {
            $inner = <<<TWIG
<div
    role="menu"
    hidden
    data-ui-role="{$subRole}"
    data-{$ctrl}-target="content"
    {{ attributes }}
>
    {% block content %}{% endblock %}
</div>

TWIG;
        } elseif ($part === 'Item') {
            $inner = <<<TWIG
<button
    type="button"
    role="menuitem"
    data-ui-role="{$subRole}"
    data-{$ctrl}-target="item"
    {{ attributes }}
>
    {% block content %}{% endblock %}
</button>

TWIG;
        } elseif ($part === 'Chip') {
            $inner = <<<TWIG
<span data-ui-role="filter-chip" data-{$ctrl}-target="chip" {{ attributes }}>
    {% block content %}{% endblock %}
    <button type="button" aria-label="Remove" data-action="click->{$controllerSlug}#removeChip">×</button>
</span>

TWIG;
        } else {
            $inner = "<div data-ui-role=\"{$subRole}\" data-{$ctrl}-target=\"" . strtolower($part) . "\" {{ attributes }}>{% block content %}{% endblock %}</div>\n";
        }

        writeFile("{$tpl}/{$component}/{$part}.html.twig", $inner);
    }

    $jsPath = "{$js}/{$controllerSlug}_controller.js";
    if (!is_file($jsPath)) {
        copy("{$js}/dropdown-menu_controller.js", $jsPath);
        echo "copied controller {$jsPath}\n";
    }
}

function scaffoldSimple(string $role, string $component, string $controllerSlug, string $rootTag = 'div', string $extraAttrs = ''): void
{
    global $src, $tpl, $js;
    $ctrl = 'symfony--ux-blocks-live--' . $controllerSlug;

    writeFile(
        "{$src}/{$component}.php",
        phpClass($component, $component, "@UxBlocksLive/components/{$component}.html.twig"),
    );
    writeFile(
        "{$tpl}/{$component}.html.twig",
        <<<TWIG
<{$rootTag}
    data-ui-role="{$role}"
    data-ui-fragment="blocks.live.{$role}"
    data-controller="{$ctrl}"
    {$extraAttrs}
    {{ attributes }}
>
    {% block content %}{% endblock %}
</{$rootTag}>

TWIG,
    );

    $jsPath = "{$js}/{$controllerSlug}_controller.js";
    if (!is_file($jsPath)) {
        $stub = <<<JS
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    connect() {}
}

JS;
        writeFile($jsPath, $stub);
    }
}

// Menu family
foreach ([
    ['menubar', 'Menubar', 'menubar'],
    ['navigation-menu', 'NavigationMenu', 'navigation-menu'],
    ['combobox', 'Combobox', 'combobox'],
] as [$role, $component, $slug]) {
    scaffoldMenu($role, $component, $slug);
}

scaffoldMenu('filter-chips', 'FilterChips', 'filter-chips', ['Chip']);

// Sidebar (drawer-like)
$role = 'sidebar';
$component = 'Sidebar';
$ctrl = 'symfony--ux-blocks-live--sidebar';
writeFile("{$src}/{$component}.php", phpClassWithProps($component, $component, "@UxBlocksLive/components/{$component}.html.twig", "    public string \$side = 'left';\n"));
writeFile("{$tpl}/{$component}.html.twig", <<<TWIG
<div
    data-ui-role="sidebar"
    data-ui-fragment="blocks.live.sidebar"
    data-controller="{$ctrl}"
    data-symfony--ux-blocks-live--sidebar-side-value="{{ side }}"
    {{ attributes }}
>
    {% block content %}{% endblock %}
</div>

TWIG);
foreach (['Trigger' => 'button', 'Content' => 'aside', 'Header' => 'div', 'Title' => 'h2'] as $part => $tag) {
    $class = $component . $part;
    $sub = 'sidebar-' . strtolower($part);
    $target = strtolower($part);
    writeFile("{$src}/{$class}.php", phpClass($class, "{$component}:{$part}", "@UxBlocksLive/components/{$component}/{$part}.html.twig"));
    $attrs = $part === 'Trigger'
        ? 'type="button" aria-expanded="false" data-symfony--ux-blocks-live--sidebar-target="trigger"'
        : ($part === 'Content' ? 'data-symfony--ux-blocks-live--sidebar-target="content"' : '');
    writeFile("{$tpl}/{$component}/{$part}.html.twig", "<{$tag} data-ui-role=\"{$sub}\" {$attrs} {{ attributes }}>{% block content %}{% endblock %}</{$tag}>\n");
}
if (!is_file("{$js}/sidebar_controller.js")) {
    copy("{$js}/sheet_controller.js", "{$js}/sidebar_controller.js");
    echo "copied sidebar controller\n";
}

scaffoldSimple('stacked-layout-interactive', 'StackedLayoutInteractive', 'stacked-layout-interactive');

// Forms
scaffoldSimple('slider', 'Slider', 'slider', 'div', 'data-symfony--ux-blocks-live--slider-target="track"');
writeFile("{$tpl}/Slider.html.twig", <<<TWIG
<div
    data-ui-role="slider"
    data-ui-fragment="blocks.live.slider"
    data-controller="symfony--ux-blocks-live--slider"
    {{ attributes }}
>
    <input type="range" data-symfony--ux-blocks-live--slider-target="input" min="0" max="100" value="50" />
    {% block content %}{% endblock %}
</div>

TWIG);

scaffoldSimple('toggle', 'Toggle', 'toggle', 'button', 'type="button" aria-pressed="false"');
scaffoldMenu('toggle-group', 'ToggleGroup', 'toggle-group', ['Item']);

writeFile("{$src}/Calendar.php", phpClass('Calendar', 'Calendar', '@UxBlocksLive/components/Calendar.html.twig'));
writeFile("{$tpl}/Calendar.html.twig", <<<TWIG
<div
    data-ui-role="calendar"
    data-ui-fragment="blocks.live.calendar"
    data-controller="symfony--ux-blocks-live--calendar"
    {{ attributes }}
>
    <div data-ui-part="grid" data-symfony--ux-blocks-live--calendar-target="grid"></div>
    {% block content %}{% endblock %}
</div>

TWIG);
writeFile("{$js}/calendar_controller.js", file_get_contents("{$js}/tabs_controller.js") ?: '');

scaffoldMenu('date-picker', 'DatePicker', 'date-picker', ['Trigger', 'Content']);

writeFile("{$src}/InputOtp.php", phpClassWithProps('InputOtp', 'InputOtp', '@UxBlocksLive/components/InputOtp.html.twig', "    public int \$length = 6;\n"));
writeFile("{$tpl}/InputOtp.html.twig", <<<TWIG
<div
    data-ui-role="input-otp"
    data-ui-fragment="blocks.live.input-otp"
    data-controller="symfony--ux-blocks-live--input-otp"
    data-symfony--ux-blocks-live--input-otp-length-value="{{ length }}"
    {{ attributes }}
>
    {% block content %}{% endblock %}
</div>

TWIG);
writeFile("{$js}/input-otp_controller.js", <<<'JS'
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['input'];
    static values = { length: { type: Number, default: 6 } };

    connect() {
        if (!this.hasInputTarget) {
            const n = this.lengthValue;
            for (let i = 0; i < n; i += 1) {
                const input = document.createElement('input');
                input.type = 'text';
                input.inputMode = 'numeric';
                input.maxLength = 1;
                input.setAttribute('data-symfony--ux-blocks-live--input-otp-target', 'input');
                input.addEventListener('input', (e) => this._onInput(e, i));
                this.element.appendChild(input);
            }
        }
    }

    _onInput(event, index) {
        const input = event.target;
        if (input.value.length === 1 && this.inputTargets[index + 1]) {
            this.inputTargets[index + 1].focus();
        }
    }
}

JS);

scaffoldSimple('rating', 'Rating', 'rating', 'div');
writeFile("{$js}/rating_controller.js", <<<'JS'
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['star'];
    static values = { max: { type: Number, default: 5 }, value: { type: Number, default: 0 } };

    connect() {
        if (this.starTargets.length === 0) {
            for (let i = 1; i <= this.maxValue; i += 1) {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.textContent = '★';
                btn.setAttribute('data-symfony--ux-blocks-live--rating-target', 'star');
                btn.setAttribute('data-value', String(i));
                btn.setAttribute('aria-pressed', 'false');
                btn.addEventListener('click', () => this.select(i));
                this.element.appendChild(btn);
            }
        }
    }

    select(value) {
        this.valueValue = value;
        this.starTargets.forEach((star) => {
            const v = Number(star.dataset.value || 0);
            star.setAttribute('aria-pressed', v <= value ? 'true' : 'false');
        });
    }
}

JS);

// Data chrome
scaffoldMenu('data-table-chrome', 'DataTableChrome', 'data-table-chrome', ['Toolbar', 'Pagination']);
writeFile("{$tpl}/DataTableChrome/Toolbar.html.twig", '<div data-ui-role="data-table-chrome-toolbar" {{ attributes }}>{% block content %}{% endblock %}</div>' . "\n");
writeFile("{$tpl}/DataTableChrome/Pagination.html.twig", '<nav data-ui-role="data-table-chrome-pagination" aria-label="Pagination" {{ attributes }}>{% block content %}{% endblock %}</nav>' . "\n");

$component = 'CarouselInteractive';
writeFile("{$src}/{$component}.php", phpClass($component, $component, "@UxBlocksLive/components/{$component}.html.twig"));
writeFile("{$tpl}/{$component}.html.twig", <<<TWIG
<div
    data-ui-role="carousel-interactive"
    data-ui-fragment="blocks.live.carousel-interactive"
    data-controller="symfony--ux-blocks-live--carousel-interactive"
    {{ attributes }}
>
    <div data-ui-role="carousel-interactive-viewport" data-symfony--ux-blocks-live--carousel-interactive-target="viewport">
        {% block content %}{% endblock %}
    </div>
</div>

TWIG);
writeFile("{$src}/CarouselInteractiveItem.php", phpClass('CarouselInteractiveItem', 'CarouselInteractive:Item', '@UxBlocksLive/components/CarouselInteractive/Item.html.twig'));
writeFile("{$tpl}/CarouselInteractive/Item.html.twig", '<div data-ui-role="carousel-interactive-item" data-symfony--ux-blocks-live--carousel-interactive-target="item" {{ attributes }}>{% block content %}{% endblock %}</div>' . "\n");
writeFile("{$js}/carousel-interactive_controller.js", <<<'JS'
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

JS);

$component = 'Resizable';
writeFile("{$src}/{$component}.php", phpClass($component, $component, "@UxBlocksLive/components/{$component}.html.twig"));
writeFile("{$tpl}/{$component}.html.twig", <<<TWIG
<div
    data-ui-role="resizable"
    data-ui-fragment="blocks.live.resizable"
    data-controller="symfony--ux-blocks-live--resizable"
    {{ attributes }}
>
    {% block content %}{% endblock %}
</div>

TWIG);
foreach (['Panel', 'Handle'] as $part) {
    $class = $component . $part;
    $sub = 'resizable-' . strtolower($part);
    writeFile("{$src}/{$class}.php", phpClass($class, "{$component}:{$part}", "@UxBlocksLive/components/{$component}/{$part}.html.twig"));
    writeFile("{$tpl}/{$component}/{$part}.html.twig", "<div data-ui-role=\"{$sub}\" data-symfony--ux-blocks-live--resizable-target=\"" . strtolower($part) . "\" {{ attributes }}>{% block content %}{% endblock %}</div>\n");
}
writeFile("{$js}/resizable_controller.js", <<<'JS'
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

JS);

writeFile("{$src}/Toast.php", phpClass('Toast', 'Toast', '@UxBlocksLive/components/Toast.html.twig'));
writeFile("{$tpl}/Toast.html.twig", <<<TWIG
<div
    data-ui-role="toast"
    data-ui-fragment="blocks.live.toast"
    data-controller="symfony--ux-blocks-live--toast"
    aria-live="polite"
    {{ attributes }}
>
    {% block content %}{% endblock %}
</div>

TWIG);
writeFile("{$src}/ToastItem.php", phpClass('ToastItem', 'Toast:Item', '@UxBlocksLive/components/Toast/Item.html.twig'));
writeFile("{$tpl}/Toast/Item.html.twig", '<div data-ui-role="toast-item" data-symfony--ux-blocks-live--toast-target="item" {{ attributes }}>{% block content %}{% endblock %}</div>' . "\n");
writeFile("{$js}/toast_controller.js", <<<'JS'
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['item'];

    show(message) {
        const el = document.createElement('div');
        el.setAttribute('data-ui-role', 'toast-item');
        el.setAttribute('data-symfony--ux-blocks-live--toast-target', 'item');
        el.textContent = message;
        this.element.appendChild(el);
        setTimeout(() => el.remove(), 4000);
    }
}

JS);

// Command palette
writeFile("{$src}/CommandPalette.php", phpClassWithProps(
    'CommandPalette',
    'CommandPalette',
    '@UxBlocksLive/components/CommandPalette.html.twig',
    "    public string \$commandsUrl = '';\n    public string \$placeholder = 'Search…';\n",
));
writeFile("{$tpl}/CommandPalette.html.twig", <<<TWIG
<div
    data-ui-role="command-palette"
    data-ui-fragment="blocks.live.command-palette"
    data-controller="symfony--ux-blocks-live--command-palette"
    data-symfony--ux-blocks-live--command-palette-commands-url-value="{{ commandsUrl }}"
    data-symfony--ux-blocks-live--command-palette-placeholder-value="{{ placeholder }}"
    hidden
    {{ attributes }}
>
    {% block content %}{% endblock %}
</div>

TWIG);
foreach (['Input' => 'input', 'List' => 'list'] as $part => $partRole) {
    $class = 'CommandPalette' . $part;
    writeFile("{$src}/{$class}.php", phpClass($class, "CommandPalette:{$part}", "@UxBlocksLive/components/CommandPalette/{$part}.html.twig"));
    writeFile("{$tpl}/CommandPalette/{$part}.html.twig", "<div data-ui-part=\"{$partRole}\" data-ui-role=\"command-palette-{$partRole}\" data-symfony--ux-blocks-live--command-palette-target=\"{$partRole}\" {{ attributes }}>{% block content %}{% endblock %}</div>\n");
}
writeFile("{$src}/CommandPaletteItem.php", phpClass('CommandPaletteItem', 'CommandPalette:Item', '@UxBlocksLive/components/CommandPalette/Item.html.twig'));
writeFile("{$tpl}/CommandPalette/Item.html.twig", '<button type="button" data-ui-role="command-palette-item" data-symfony--ux-blocks-live--command-palette-target="item" {{ attributes }}>{% block content %}{% endblock %}</button>' . "\n");
writeFile("{$js}/command-palette_controller.js", <<<'JS'
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['input', 'list', 'item'];
    static values = {
        commandsUrl: String,
        placeholder: { type: String, default: 'Search…' },
        openHotkey: { type: String, default: 'k' },
    };

    connect() {
        this._commands = [];
        this._onKeydown = this._onKeydown.bind(this);
        document.addEventListener('keydown', this._onKeydown);
        if (this.commandsUrlValue) {
            fetch(this.commandsUrlValue)
                .then((r) => r.json())
                .then((data) => {
                    this._commands = Array.isArray(data.commands) ? data.commands : data;
                    this._render();
                })
                .catch(() => {});
        }
        if (this.hasInputTarget) {
            this.inputTarget.placeholder = this.placeholderValue;
            this.inputTarget.addEventListener('input', () => this._filter());
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
        if (event.key === 'Escape') {
            this.element.hidden = true;
        }
    }

    _filter() {
        const q = this.hasInputTarget ? this.inputTarget.value.toLowerCase() : '';
        this.itemTargets.forEach((el) => {
            const label = (el.textContent || '').toLowerCase();
            el.hidden = q !== '' && !label.includes(q);
        });
    }

    _render() {
        if (!this.hasListTarget) {
            return;
        }
        this.listTarget.innerHTML = '';
        this._commands.forEach((cmd) => {
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.setAttribute('data-ui-role', 'command-palette-item');
            btn.setAttribute('data-symfony--ux-blocks-live--command-palette-target', 'item');
            btn.textContent = cmd.label || cmd.title || cmd.id || 'Command';
            if (cmd.url) {
                btn.addEventListener('click', () => {
                    window.location.href = cmd.url;
                });
            }
            this.listTarget.appendChild(btn);
        });
    }
}

JS);

writeFile("{$js}/stacked-layout-interactive_controller.js", <<<'JS'
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['nav', 'panel'];

    connect() {
        this.element.querySelectorAll('[data-ui-part="nav"] a, [data-ui-part="nav"] button').forEach((el) => {
            el.addEventListener('click', (e) => {
                const id = el.dataset.panel;
                if (id) {
                    e.preventDefault();
                    this._show(id);
                }
            });
        });
    }

    _show(id) {
        this.panelTargets.forEach((p) => {
            p.hidden = p.dataset.panelId !== id;
        });
    }
}

JS);

writeFile("{$tpl}/StackedLayoutInteractive.html.twig", <<<TWIG
<div
    data-ui-role="stacked-layout-interactive"
    data-ui-fragment="blocks.live.stacked-layout-interactive"
    data-controller="symfony--ux-blocks-live--stacked-layout-interactive"
    {{ attributes }}
>
    <nav data-ui-part="nav" data-symfony--ux-blocks-live--stacked-layout-interactive-target="nav">
        {% block nav %}{% endblock %}
    </nav>
    <main>
        {% block content %}{% endblock %}
    </main>
</div>

TWIG);

writeFile("{$js}/slider_controller.js", <<<'JS'
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = ['input'];

    connect() {
        if (this.hasInputTarget) {
            this.inputTarget.addEventListener('input', () => {
                this.element.dispatchEvent(new CustomEvent('slider:change', { detail: { value: this.inputTarget.value } }));
            });
        }
    }
}

JS);

writeFile("{$js}/toggle_controller.js", <<<'JS'
import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    toggle() {
        const pressed = this.element.getAttribute('aria-pressed') === 'true';
        this.element.setAttribute('aria-pressed', pressed ? 'false' : 'true');
    }
}

JS);

copy("{$js}/tabs_controller.js", "{$js}/toggle-group_controller.js");
copy("{$js}/dropdown-menu_controller.js", "{$js}/date-picker_controller.js");

echo "Scaffold complete.\n";
