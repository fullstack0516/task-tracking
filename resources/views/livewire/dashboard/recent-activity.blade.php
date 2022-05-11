<x-card>
    <h2 class="text-lg font-medium text-gray-900 dark:text-white">
        {{ __('Recent Activity') }}
    </h2>

    <div class="mt-4 space-y-6">
        <div class="flow-root">
            <ul role="list" class="-mb-8">
                @forelse ($logs as $log)
                    @continue(! $log->subject || ! $log->causer)

                    <li>
                        @if ($log->subject_type === \App\Models\Task::class)
                            <x-activity.task :log="$log" :is-last="$loop->last" />
                        @elseif ($log->subject_type === \App\Models\Project::class)
                            <x-activity.project :log="$log" :is-last="$loop->last" />
                        @elseif ($log->subject_type === \App\Models\TimeEntry::class)
                            <x-activity.time-entry :log="$log" :is-last="$loop->last" />
                        @else
                            <x-activity.empty-log :is-last="$loop->last" />
                        @endif
                    </li>
                @empty
                    @for ($i = 0; $i <= 5; $i++)
                        <x-activity.empty-log :is-last="$i === 5" />
                    @endfor
                @endforelse
            </ul>
        </div>
    </div>
</x-card>
