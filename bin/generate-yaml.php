#!/usr/bin/env php
<?php

declare(strict_types=1);

$root = dirname(__DIR__, 3) . '/packages';

$coreRoles = [
    ['role' => 'typography', 'twig' => 'Typography', 'class' => 'Typography', 'status' => 'v0'],
    ['role' => 'button', 'twig' => 'Button', 'class' => 'Button', 'status' => 'v0', 'interaction' => 'nat, act'],
    ['role' => 'label', 'twig' => 'Label', 'class' => 'Label', 'status' => 'v0'],
    ['role' => 'input', 'twig' => 'Input', 'class' => 'Input', 'status' => 'v0'],
    ['role' => 'textarea', 'twig' => 'Textarea', 'class' => 'Textarea', 'status' => 'v0'],
    ['role' => 'checkbox', 'twig' => 'Checkbox', 'class' => 'Checkbox', 'status' => 'v0'],
    ['role' => 'select', 'twig' => 'Select', 'class' => 'Select', 'status' => 'v0'],
    ['role' => 'switch', 'twig' => 'Switch', 'class' => 'SwitchControl', 'status' => 'v1'],
    ['role' => 'file-input', 'twig' => 'FileInput', 'class' => 'FileInput', 'status' => 'v1'],
    ['role' => 'separator', 'twig' => 'Separator', 'class' => 'Separator', 'status' => 'v0'],
    ['role' => 'divider', 'twig' => 'Divider', 'class' => 'Divider', 'status' => 'v1'],
    ['role' => 'aspect-ratio', 'twig' => 'AspectRatio', 'class' => 'AspectRatio', 'status' => 'v1'],
    ['role' => 'scroll-area', 'twig' => 'ScrollArea', 'class' => 'ScrollArea', 'status' => 'v1'],
    ['role' => 'badge', 'twig' => 'Badge', 'class' => 'Badge', 'status' => 'v1'],
    ['role' => 'avatar', 'twig' => 'Avatar', 'class' => 'Avatar', 'status' => 'v1'],
    ['role' => 'kbd', 'twig' => 'Kbd', 'class' => 'Kbd', 'status' => 'v1'],
    ['role' => 'link', 'twig' => 'Link', 'class' => 'Link', 'status' => 'v1'],
    ['role' => 'progress', 'twig' => 'Progress', 'class' => 'Progress', 'status' => 'v1'],
    ['role' => 'spinner', 'twig' => 'Spinner', 'class' => 'Spinner', 'status' => 'v1', 'variants' => ['size' => ['sm', 'md', 'lg'], 'density' => ['inline', 'block']]],
    ['role' => 'skeleton', 'twig' => 'Skeleton', 'class' => 'Skeleton', 'status' => 'v1'],
    ['role' => 'empty', 'twig' => 'Empty', 'class' => 'EmptyState', 'status' => 'v0'],
    ['role' => 'image', 'twig' => 'Image', 'class' => 'Image', 'status' => 'v1'],
];

$extRoles = [
    ['role' => 'field', 'twig' => 'Field', 'class' => 'Field'],
    ['role' => 'fieldset', 'twig' => 'Fieldset', 'class' => 'Fieldset'],
    ['role' => 'radio-group', 'twig' => 'RadioGroup', 'class' => 'RadioGroup'],
    ['role' => 'input-group', 'twig' => 'InputGroup', 'class' => 'InputGroup'],
    ['role' => 'button-group', 'twig' => 'ButtonGroup', 'class' => 'ButtonGroup'],
    ['role' => 'card', 'twig' => 'Card', 'class' => 'Card'],
    ['role' => 'table', 'twig' => 'Table', 'class' => 'Table'],
    ['role' => 'alert', 'twig' => 'Alert', 'class' => 'Alert'],
    ['role' => 'grid', 'twig' => 'Grid', 'class' => 'Grid'],
    ['role' => 'stack', 'twig' => 'Stack', 'class' => 'Stack'],
    ['role' => 'list', 'twig' => 'List', 'class' => 'ListBox'],
    ['role' => 'description-list', 'twig' => 'DescriptionList', 'class' => 'DescriptionList'],
    ['role' => 'stat', 'twig' => 'Stat', 'class' => 'Stat'],
    ['role' => 'timeline', 'twig' => 'Timeline', 'class' => 'Timeline'],
    ['role' => 'accordion', 'twig' => 'Accordion', 'class' => 'Accordion'],
    ['role' => 'carousel', 'twig' => 'Carousel', 'class' => 'Carousel'],
    ['role' => 'dialog', 'twig' => 'Dialog', 'class' => 'Dialog'],
    ['role' => 'popover', 'twig' => 'Popover', 'class' => 'Popover'],
    ['role' => 'tooltip', 'twig' => 'Tooltip', 'class' => 'Tooltip'],
    ['role' => 'navbar', 'twig' => 'Navbar', 'class' => 'Navbar'],
    ['role' => 'breadcrumb', 'twig' => 'Breadcrumb', 'class' => 'Breadcrumb'],
    ['role' => 'steps', 'twig' => 'Steps', 'class' => 'Steps'],
    ['role' => 'pagination', 'twig' => 'Pagination', 'class' => 'Pagination', 'interaction' => 'nat, act'],
    ['role' => 'page-heading', 'twig' => 'PageHeading', 'class' => 'PageHeading'],
    ['role' => 'section-heading', 'twig' => 'SectionHeading', 'class' => 'SectionHeading'],
    ['role' => 'auth-layout', 'twig' => 'AuthLayout', 'class' => 'AuthLayout'],
    ['role' => 'dashboard-shell', 'twig' => 'DashboardShell', 'class' => 'DashboardShell', 'interaction' => 'nat, act'],
    ['role' => 'data-table-chrome', 'twig' => 'DataTableChrome', 'class' => 'DataTableChrome'],
];

$liveRoles = [
    ['role' => 'collapsible', 'twig' => 'Collapsible', 'class' => 'Collapsible'],
    ['role' => 'tabs', 'twig' => 'Tabs', 'class' => 'Tabs'],
    ['role' => 'alert-dialog-enhanced', 'twig' => 'AlertDialog', 'class' => 'AlertDialog'],
    ['role' => 'drawer', 'twig' => 'Drawer', 'class' => 'Drawer'],
    ['role' => 'sheet', 'twig' => 'Sheet', 'class' => 'Sheet'],
    ['role' => 'dropdown-menu', 'twig' => 'DropdownMenu', 'class' => 'DropdownMenu'],
    ['role' => 'combobox', 'twig' => 'Combobox', 'class' => 'Combobox'],
    ['role' => 'slider', 'twig' => 'Slider', 'class' => 'Slider'],
    ['role' => 'toggle', 'twig' => 'Toggle', 'class' => 'Toggle'],
    ['role' => 'toggle-group', 'twig' => 'ToggleGroup', 'class' => 'ToggleGroup'],
    ['role' => 'calendar', 'twig' => 'Calendar', 'class' => 'Calendar'],
    ['role' => 'date-picker', 'twig' => 'DatePicker', 'class' => 'DatePicker'],
    ['role' => 'date-range-picker', 'twig' => 'DateRangePicker', 'class' => 'DateRangePicker', 'ref' => 'dsikeres1'],
    ['role' => 'input-otp', 'twig' => 'InputOtp', 'class' => 'InputOtp'],
    ['role' => 'tags-input', 'twig' => 'TagsInput', 'class' => 'TagsInput', 'ref' => 'kibo-ui'],
    ['role' => 'sidebar', 'twig' => 'Sidebar', 'class' => 'Sidebar'],
    ['role' => 'stacked-layout-interactive', 'twig' => 'StackedLayoutInteractive', 'class' => 'StackedLayoutInteractive'],
    ['role' => 'command-palette', 'twig' => 'CommandPalette', 'class' => 'CommandPalette', 'interaction' => 'stl, runtime'],
    ['role' => 'toast', 'twig' => 'Toast', 'class' => 'Toast'],
    ['role' => 'context-menu', 'twig' => 'ContextMenu', 'class' => 'ContextMenu'],
    ['role' => 'hover-card', 'twig' => 'HoverCard', 'class' => 'HoverCard'],
    ['role' => 'resizable', 'twig' => 'Resizable', 'class' => 'Resizable'],
    ['role' => 'menubar', 'twig' => 'Menubar', 'class' => 'Menubar'],
    ['role' => 'navigation-menu', 'twig' => 'NavigationMenu', 'class' => 'NavigationMenu'],
    ['role' => 'data-table-chrome-interactive', 'twig' => 'DataTableChromeInteractive', 'class' => 'DataTableChromeInteractive', 'interaction' => 'stl, act'],
    ['role' => 'carousel-interactive', 'twig' => 'CarouselInteractive', 'class' => 'CarouselInteractive'],
    ['role' => 'rating', 'twig' => 'Rating', 'class' => 'Rating'],
    ['role' => 'filter-chips', 'twig' => 'FilterChips', 'class' => 'FilterChips'],
    ['role' => 'table-of-contents', 'twig' => 'TableOfContents', 'class' => 'TableOfContents'],
    ['role' => 'tree-view', 'twig' => 'TreeView', 'class' => 'TreeView', 'ref' => 'kibo-ui'],
];

function yamlRow(string $prefix, string $ns, array $row, string $defaultInteraction = 'nat'): array
{
    $role = $row['role'];
    $interaction = $row['interaction'] ?? $defaultInteraction;
    $entry = [
        'role' => $role,
        'twig_component' => $row['twig'],
        'php_class' => sprintf('Symfinity\\%s\\Twig\\Components\\%s', $ns, $row['class']),
        'fragment_id' => $prefix . '.' . $role,
        'fragment_pattern' => sprintf('"%s.%s.{n}"', $prefix, $role),
        'interaction' => $interaction,
        'stage' => 'A',
        'status' => $row['status'] ?? 'shipped',
    ];
    if (isset($row['variants'])) {
        $entry['variants'] = $row['variants'];
    }
    if (isset($row['ref'])) {
        $entry['ref'] = $row['ref'];
    }
    if (isset($row['alias'])) {
        $entry['deprecated_fragment_alias'] = $row['alias'];
    }

    return $entry;
}

function dumpYaml(string $path, string $schema, string $prefix, string $ns, array $roles, string $defaultInteraction, array $aliases = []): void
{
    $lines = [
        'ux_role_registry: "' . $schema . '"',
        'registry_prefix: ' . explode('.', $prefix)[0] . (str_contains($prefix, '.') ? '.' . explode('.', $prefix, 2)[1] : ''),
        'roles:',
    ];

    if ($prefix === 'blocks') {
        $registryPrefix = 'blocks';
    } elseif ($prefix === 'blocks.ext') {
        $registryPrefix = 'blocks.ext';
    } else {
        $registryPrefix = 'blocks.live';
    }

    $lines[1] = 'registry_prefix: ' . $registryPrefix;

    foreach ($roles as $role) {
        $entry = yamlRow($prefix, $ns, $role, $defaultInteraction);
        $lines[] = '  - role: ' . $entry['role'];
        foreach ($entry as $key => $value) {
            if ($key === 'role') {
                continue;
            }
            if ($key === 'variants') {
                $lines[] = '    variants:';
                foreach ($value as $vk => $vv) {
                    $lines[] = '      ' . $vk . ': [' . implode(', ', $vv) . ']';
                }
                continue;
            }
            if (is_string($value) && str_contains($value, '{n}')) {
                $lines[] = '    ' . $key . ': ' . $value;
            } else {
                $lines[] = '    ' . $key . ': ' . $value;
            }
        }
    }

    if ($aliases !== []) {
        $lines[] = 'deprecated_fragment_aliases:';
        foreach ($aliases as $from => $to) {
            $lines[] = '  - from: ' . $from;
            $lines[] = '    to: ' . $to;
            $lines[] = '    sunset: next-minor';
        }
    }

    file_put_contents($path, implode("\n", $lines) . "\n");
}

$coreAliases = [];
foreach ($extRoles as $r) {
    $coreAliases['blocks.' . $r['role']] = 'blocks.ext.' . $r['role'];
}

$liveAliases = [];
foreach ($liveRoles as $r) {
    if ($r['role'] === 'collapsible') {
        continue;
    }
    if ($r['role'] === 'data-table-chrome-interactive') {
        $liveAliases['blocks.ext.data-table-chrome'] = 'blocks.live.data-table-chrome-interactive';
        continue;
    }
    $liveAliases['blocks.ext.' . $r['role']] = 'blocks.live.' . $r['role'];
}

dumpYaml($root . '/ux-blocks-core/config/ux_roles.yaml', '1.3', 'blocks', 'UxBlocksCore', $coreRoles, 'nat');
dumpYaml($root . '/ux-blocks-extended/config/ux_roles.yaml', '1.3', 'blocks.ext', 'UxBlocksExtended', $extRoles, 'nat', $coreAliases);
dumpYaml($root . '/ux-blocks-live/config/ux_roles.yaml', '1.3', 'blocks.live', 'UxBlocksLive', $liveRoles, 'stl', $liveAliases);

echo "Generated ux_roles.yaml for core (" . count($coreRoles) . "), extended (" . count($extRoles) . "), live (" . count($liveRoles) . ")\n";
