@props(['id' => null, 'maxWidth' => null, 'submit'])

<x-jet-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="px-6 py-4">
        <div class="flex justify-between items-center">
            <h2 class="text-lg font-medium">
                {{ $title }}
            </h2>

            <button class="-m-2 p-2 rounded-md text-gray-400 hover:text-gray-600 transition" x-on:click="show = false">
                <x-heroicon-o-x class="w-5 h-5" />
            </button>
        </div>

        <div class="mt-4">
            {{ $slot }}
        </div>

        @if (isset($footer))
            <div class="mt-6">
                {{ $footer }}
            </div>
        @endif
    </div>
</x-jet-modal>
