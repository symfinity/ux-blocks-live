/**
 * Roving tabindex for menu / tabs lists (internal).
 */
export function rovingKeydown(event, items, activeIndex, orientation = 'horizontal') {
    const max = items.length - 1;
    if (max < 0) {
        return activeIndex;
    }

    const prevKey = orientation === 'vertical' ? 'ArrowUp' : 'ArrowLeft';
    const nextKey = orientation === 'vertical' ? 'ArrowDown' : 'ArrowRight';

    switch (event.key) {
        case prevKey:
            event.preventDefault();
            return activeIndex <= 0 ? max : activeIndex - 1;
        case nextKey:
            event.preventDefault();
            return activeIndex >= max ? 0 : activeIndex + 1;
        case 'Home':
            event.preventDefault();
            return 0;
        case 'End':
            event.preventDefault();
            return max;
        default:
            return activeIndex;
    }
}

export function applyRovingTabindex(items, activeIndex) {
    items.forEach((item, index) => {
        item.tabIndex = index === activeIndex ? 0 : -1;
    });
    items[activeIndex]?.focus();
}
