@props(['id' => null, 'maxWidth' => null])

<x-jet-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="p-6">
        <div class="font-medium text-lg">
            {{ $title }}
        </div>

        <div class="mt-4">
            {{ $content }}
        </div>

        <div class="flex mt-4 space-x-3">
            {{ $footer }}
        </div>
    </div>
</x-jet-modal>
