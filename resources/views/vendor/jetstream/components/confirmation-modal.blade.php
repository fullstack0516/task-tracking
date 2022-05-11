@props(['id' => null, 'maxWidth' => null])

<x-jet-modal :id="$id" :maxWidth="$maxWidth" {{ $attributes }}>
    <div class="bg-white p-4 sm:p-6">
        <div class="sm:flex sm:items-start">
            <div class="mx-auto shrink-0 sm:mx-0 sm:h-10 sm:w-10">
                <x-heroicon-o-exclamation class="h-8 w-8 text-rose-600" />
            </div>

            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                <h3 class="font-medium text-lg">
                    {{ $title }}
                </h3>

                <div class="mt-2">
                    {{ $content }}
                </div>
            </div>
        </div>

        <div class="flex mt-4 space-x-3">
            {{ $footer }}
        </div>
    </div>
</x-jet-modal>
