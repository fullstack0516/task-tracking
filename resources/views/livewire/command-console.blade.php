@php
$id = md5('cmd-k-modal');

$maxWidth = [
    'sm' => 'sm:max-w-sm',
    'md' => 'sm:max-w-md',
    'lg' => 'sm:max-w-lg',
    'xl' => 'sm:max-w-xl',
    '2xl' => 'sm:max-w-2xl',
    '4xl' => 'sm:max-w-4xl',
]['2xl'];
@endphp

<div
    x-data="{
        show: false,
        query: @entangle('query'),
        focusables() {
            // All focusable element types...
            let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'

            return [...$el.querySelectorAll(selector)]
                // All non-disabled elements...
                .filter(el => ! el.hasAttribute('disabled'))
        },
        firstFocusable() { return this.focusables()[0] },
        lastFocusable() { return this.focusables().slice(-1)[0] },
        nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
        prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
        nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
        prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) -1 },
    }"
    x-init="$watch('show', value => {
        if (value) {
            document.body.classList.add('overflow-y-hidden');
            setTimeout(() => firstFocusable().focus(), 100);
        } else {
            document.body.classList.remove('overflow-y-hidden');
        }
    })"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
    x-on:keydown.shift.tab.prevent="prevFocusable().focus()"
    @keydown.window.prevent.cmd.k="show = true"
    x-show="show"
    id="{{ $id }}"
    class="jetstream-modal fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
    style="display: none;"
>
    <div
        x-show="show"
        class="fixed inset-0 transform transition-all"
        x-on:click="show = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div class="absolute inset-0 bg-gray-800 opacity-50"></div>
    </div>

    <div
        x-show="show"
        class="mb-6 p-2 bg-white rounded-xl overflow-hidden shadow-xl transform transition-all sm:w-full {{ $maxWidth }} sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >
        <input
            type="text"
            class="w-full rounded-md border-0 bg-gray-100 px-4 py-2.5 text-gray-900 placeholder-gray-500 focus:ring-0 sm:text-sm"
            placeholder="Search..."
            role="combobox"
            aria-expanded="false"
            aria-controls="options"
            x-model="query"
        >

        <!-- Results, show/hide based on command palette state. -->


        <ul
            class="-mb-2 max-h-72 scroll-py-2 overflow-y-auto py-2 text-sm text-gray-800"
            id="options"
            role="listbox"
            x-show="query != ''"
            style="display: none;"
        >
            <!-- Active: "bg-indigo-600 text-white" -->
            @php($i = 0)

            @foreach ($itemGroups as $group => $items)
                @php($i++)

                <li class="p-2" role="none">
                    <h2 class="mb-2 px-3 text-xs font-semibold text-gray-500" role="none">{{ ucfirst($group) }}</h2>

                    <ul class="text-sm text-gray-700" role="none">
                        @foreach ($items as $key => $item)
                            <li class="cursor-default select-none rounded-md px-3 py-2" id="option-{{ $item->id }}" role="option" tabindex="-1">
                                <span class="flex-auto truncate">{{ $item->name }}</span>
                            </li>
                        @endforeach
                    </ul>
                </li>
            @endforeach
        </ul>

        <!-- Empty state, show/hide based on command palette state. -->
        <div class="py-14 px-4 text-center sm:px-14" x-show="query == ''">
            <x-heroicon-o-search class="mx-auto h-6 w-6 text-gray-400" />
            <p class="mt-4 text-sm text-gray-900">
                {{ __('No results found using that search term.') }}
            </p>
        </div>
    </div>
</div>
