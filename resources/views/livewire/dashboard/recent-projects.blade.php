<x-card>
    <h2 class="text-lg font-medium text-gray-900 dark:text-white">
        {{ __('Recent Projects') }}
    </h2>

    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-3">
        @forelse ($projects as $project)
            <x-project.mini :item="$project" />
        @empty
            @for ($i = 0; $i <= 5; $i++)
                <x-project.empty-mini />
            @endfor
        @endforelse
    </div>
</x-card>
