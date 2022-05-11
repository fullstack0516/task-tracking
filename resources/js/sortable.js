import Sortable from 'sortablejs';

if (typeof window.livewire === 'undefined') {
    throw 'Livewire Sortable Plugin: window.livewire is undefined. Make sure @livewireScripts is placed above this script include';
}

window.livewire.directive('sortable-group', (groupsEl, directive, component) => {
    // Only fire the rest of this handler on the "root" directive.
    if (directive.modifiers.length > 0) return;

    groupsEl.querySelectorAll('[wire\\:sortable-group\\.item-group]').forEach((el, index) => {
        let movedGroup = null;

        const sortable = new Sortable(el, {
            group: 'shared',
            draggable: '[wire\\:sortable-group\\.item]',
            animation: 150,
            onEnd: (e) => {
                setTimeout(() => {
                    let groups = [];

                    groupsEl.querySelectorAll('[wire\\:sortable-group\\.item-group]').forEach((itemGroupEl, index) => {
                        let items = [];

                        itemGroupEl.querySelectorAll('[wire\\:sortable-group\\.item]').forEach((itemEl, index) => {
                            items.push({
                                order: index + 1,
                                value: itemEl.getAttribute('wire:sortable-group.item'),
                            });
                        });

                        groups.push({
                            order: index + 1,
                            value: itemGroupEl.getAttribute('wire:sortable-group.item-group'),
                            items: items,
                        });
                    });

                    component.call(directive.method, groups);
                }, 1);
            },
        });
    });
});

window.livewire.directive('sortable', (el, directive, component) => {
    // Only fire this handler on the "root" directive.
    if (directive.modifiers.length > 0) return;

    const sortable = new Sortable(el, {
        draggable: '[wire\\:sortable\\.item]',
        animation: 150,
        onEnd: (e) => {
            setTimeout(() => {
                let items = [];

                el.querySelectorAll('[wire\\:sortable\\.item]').forEach((el, index) => {
                    items.push({
                        order: index + 1,
                        value: el.getAttribute('wire:sortable.item'),
                    });
                });

                component.call(directive.method, items);
            }, 1);
        },
    });
});
