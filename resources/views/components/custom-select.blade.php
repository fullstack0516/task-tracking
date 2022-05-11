@props(['items', 'classes' => 'mt-1 relative'])

<div x-data="{
    open: false,
    activeItem: null,
    selectedItem: @entangle($attributes->wire('model')).defer,
    items: {{ $items }},
    activeDescendant: null,
    get active() {
        return this.items.find(item => item.id === this.activeItem)
    },
    get selected() {
        return this.items.find(item => item.id === this.selectedItem)
    },
    choose(itemId) {
        this.selectedItem = itemId
        this.open = !1
    },
    init() {
        this.optionCount = this.$refs.listbox.children.length, this.$watch('activeItem', (e => {
            this.open && (null !== this.activeItem ? this.activeDescendant = this.$refs.listbox.children[this.activeItem].id : this.activeDescendant = '')
        }))
    },
    onButtonClick() {
        this.open || (this.activeItem = this.selectedItem, this.open = !0, this.$nextTick((() => {
            this.$refs.listbox.focus(), this.$refs.listbox.children[this.activeItem].scrollIntoView({
                block: 'nearest'
            })
        })))
    },
    onOptionSelect() {
        null !== this.activeItem && (this.selectedItem = this.activeItem), this.open = !1, this.$refs.button.focus()
    },
    onEscape() {
        this.open = !1, this.$refs.button.focus()
    },
    onArrowUp() {
        this.activeItem = this.activeItem - 1 < 0 ? this.optionCount - 1 : this.activeItem - 1, this.$refs.listbox.children[this.activeItem].scrollIntoView({
            block: 'nearest'
        })
    },
    onArrowDown() {
        this.activeItem = this.activeItem + 1 > this.optionCount - 1 ? 0 : this.activeItem + 1, this.$refs.listbox.children[this.activeItem].scrollIntoView({
            block: 'nearest'
        })
    },
}" x-init="init()">
    <div class="{{ $classes }}">
        <button
            type="button"
            class="relative w-full bg-white border border-gray-300 rounded-lg shadow-sm pl-3 pr-10 py-2 text-left cursor-default focus:outline-none focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
            x-ref="button"
            @keydown.arrow-up.stop.prevent="onButtonClick()"
            @keydown.arrow-down.stop.prevent="onButtonClick()"
            @click="onButtonClick()"
            aria-haspopup="listbox"
            :aria-expanded="open"
            aria-expanded="true"
            aria-labelledby="listbox-label"
        >
            <span x-text="selected ? selected.name : 'Select an option'" class="block truncate"></span>
            <span class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none">
                <x-heroicon-s-selector class="h-5 w-5 text-gray-400" />
            </span>
        </button>

        <ul
            x-show="open"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="absolute z-10 mt-1 w-full bg-white shadow-lg max-h-60 rounded-md py-1 text-base ring-1 ring-black ring-opacity-5 overflow-auto focus:outline-none sm:text-sm"
            x-max="1"
            @click.away="open = false"
            @keydown.enter.stop.prevent="onOptionSelect()"
            @keydown.space.stop.prevent="onOptionSelect()"
            @keydown.escape="onEscape()"
            @keydown.arrow-up.prevent="onArrowUp()"
            @keydown.arrow-down.prevent="onArrowDown()"
            x-ref="listbox"
            tabindex="-1"
            role="listbox"
            aria-labelledby="listbox-label"
            :aria-activedescendant="activeDescendant"
            aria-activedescendant=""
        >
            <template x-for="item in items">
                <li
                    x-state:on="Highlighted"
                    x-state:off="Not Highlighted"
                    class="cursor-default select-none relative py-2 pl-3 pr-9 text-gray-900"
                    id="listbox-option-0"
                    role="option"
                    @click="choose(item.id)"
                    @mouseenter="activeItem = item.id"
                    @mouseleave="activeItem = null"
                    :class="{ 'text-white bg-indigo-600': activeItem === item.id, 'text-gray-900': !(activeItem === item.id) }"
                >
                    <span
                        x-state:on="Selected"
                        x-state:off="Not Selected"
                        class="block truncate font-semibold"
                        :class="{ 'font-semibold': selectedItem === item.id, 'font-normal': !(selectedItem === item.id) }"
                        x-text="item.name"
                    ></span>

                    <span
                        x-state:on="Highlighted"
                        x-state:off="Not Highlighted"
                        class="absolute inset-y-0 right-0 flex items-center pr-4 text-indigo-600"
                        :class="{ 'text-white': activeItem === item.id, 'text-indigo-600': !(activeItem === item.id) }"
                        x-show="selectedItem === item.id"
                    >
                        <x-heroicon-s-check class="h-5 w-5" />
                    </span>
                </li>
            </template>
        </ul>
    </div>
</div>
