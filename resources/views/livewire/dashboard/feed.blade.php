<div>
    <div class="space-y-4">
        @forelse ($items as $item)
            <x-card>
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img class="h-8 w-8 rounded-full object-cover" src="{{ $item->causer->profile_photo_url }}" alt="{{ $item->causer->name }}">
                        <div class="ml-3">
                            <p class="text-sm leading-tight text-gray-900 dark:text-white">{{ $item->causer->name }}</p>
                            <p class="text-xs text-gray-600 leading-tight">{{ $item->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    @if ($item->subject_type === \App\Models\Task::class)
                        <x-activity.task :item="$item" />
                    @elseif ($item->subject_type === \App\Models\Project::class)
                        <x-activity.project :item="$item" />
                    @elseif ($item->subject_type === \App\Models\TimeEntry::class)
                        <x-activity.time-entry :item="$item" />
                    @elseif ($item->subject_type === \App\Models\Retainer::class)
                        <x-activity.retainer :item="$item" />
                    @else
                        <p class="text-rose-500">{{ __('Whoops! This shouldn\'t happen...') }}</p>
                    @endif
                </div>
            </x-card>
        @empty
            <x-empty-card />
        @endforelse
    </div>

    @if ($totalPages > $page)
        <div class="mt-8 flex justify-center">
            <button type="button" wire:click="loadMore" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-lg font-semibold text-xs text-gray-700 tracking-wide hover:bg-gray-700 hover:text-white active:bg-gray-900 active:text-white focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                {{ __('Load more') }}
            </button>
        </div>
    @endif
</div>
