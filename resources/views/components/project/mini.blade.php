@props(['item'])

<div class="relative -m-2 p-3 rounded-lg hover:bg-gray-100">
    <div class="flex items-center space-x-3">
        <x-badge :model="$item" />

        <div>
            <h3 class="text-sm font-medium leading-4">
                {{ $item->name }}
            </h3>

            <p class="mt-0.5 text-xs font-normal leading-4 text-gray-500">
                {{ $item->outstandingTasks->count() }} {{ __('tasks') }}
            </p>
        </div>
    </div>

    <a href="{{ route('projects.overview', $item) }}" class="absolute inset-0 rounded-lg focus:z-10 focus:outline-none focus:ring-2 ring-indigo-400"></a>
</div>
