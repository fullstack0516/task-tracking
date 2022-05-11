<div>
    <x-slideout max-width="4xl" wire:model="showModal">
        <x-slot name="title">
            {{ __(sprintf('%s Task', ucfirst($target))) }}
        </x-slot>

        <form class="space-y-6" wire:submit.prevent="{{ $target }}" x-data="{ loading: false }">
            <div>
                <x-jet-label for="title" value="{{ __('Title') }}" />
                <x-jet-input id="title" class="block mt-1 w-full" type="text" wire:model.defer="state.title" />
                <x-jet-input-error for="title" class="mt-2" />
            </div>

            <div x-data="{ mode: 'editor' }" wire:ignore>
                <x-jet-label for="description" value="{{ __('Description') }}" />
                <div x-data="{
                    description: @entangle('state.description').defer,
                    init() {
                        let editor = new Editor({
                            el: this.$refs.editor,
                            initialEditType: 'wysiwyg',
                            hideModeSwitch: true,
                            autofocus: false,
                            height: 'auto',
                            minHeight: '5em',
                            toolbarItems: [
                                ['heading', 'bold', 'italic', 'strike'],
                                ['ul', 'ol'],
                                ['image', 'link'],
                            ],
                            events: {
                                load: (editor) => {
                                    window.addEventListener('editor', event => {
                                        if (this.description) {
                                            editor.setMarkdown(this.description);
                                        } else {
                                            editor.setMarkdown('');
                                        }
                                    });
                                },
                                change: (change) => {
                                    this.description = editor.getMarkdown();
                                },
                            },
                        });

                        {{-- editor.insertToolbarItem({ groupIndex: 0, itemIndex: 1 }, {
                            name: 'myBold',
                            tooltip: 'Bold',
                            command: 'bold',
                            text: 'B',
                            className: 'toastui-editor-toolbar-icons',
                            style: { backgroundImage: 'none' },
                        }); --}}
                    },
                }">
                    <div x-ref="editor" class="block mt-1 w-full"></div>
                </div>
                <x-jet-input-error for="description" class="mt-2" />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <x-jet-label for="type" value="{{ __('Type') }}" />
                    <x-custom-select
                        id="type"
                        class="block mt-1 w-full"
                        wire:model="state.type"
                        :items="json_encode([
                            ['id' => 'task', 'name' => 'Task'],
                            ['id' => 'bug', 'name' => 'Bug'],
                            ['id' => 'story', 'name' => 'Story'],
                        ])"
                    />
                    <x-jet-input-error for="type" class="mt-2" />
                </div>

                <div>
                    <x-jet-label for="priority" value="{{ __('Priority') }}" />
                    <x-custom-select
                        id="priority"
                        class="block mt-1 w-full"
                        wire:model="state.priority"
                        :items="json_encode([
                            ['id' => 'high', 'name' => 'High'],
                            ['id' => 'medium', 'name' => 'Medium'],
                            ['id' => 'low', 'name' => 'Low'],
                        ])"
                    />
                    <x-jet-input-error for="priority" class="mt-2" />
                </div>

                @if (in_array($task?->type, ['task', 'bug']) && $project->tasks->where('type', 'story')->count())
                    <div>
                        <x-jet-label for="parent_task_id" value="{{ __('Assign to Story') }}" />
                        <x-custom-select
                            id="parent_task_id"
                            class="block mt-1 w-full"
                            wire:model="state.parent_task_id"
                            :items="json_encode($project->tasks->where('type', 'story')->map(fn ($item) => [
                                'id' => $item->id,
                                'name' => $item->title,
                            ])->values()->all())"
                        />
                        <x-jet-input-error for="parent_task_id" class="mt-2" />
                    </div>
                @endif

                @if ($task?->tasks->count())
                    <div>
                        <x-jet-label value="{{ __('Associated Tasks') }}" />
                        <div class="mt-1 border divide-y rounded-md">
                            @foreach ($task->tasks as $subTask)
                                <div class="p-4 flex items-center justify-between">
                                    <p class="text-sm font-semibold text-gray-800 leading-tight">
                                        {{ $subTask->title }}
                                    </p>

                                    <div class="flex items-center space-x-2">
                                        <x-task.type type="{{ $subTask->type }}" />

                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            #{{ $subTask->id }}
                                        </span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($project?->taskGroups->count())
                    <div>
                        <x-jet-label for="task_group_id" value="{{ __('Status') }}" />
                        <x-custom-select
                            id="task_group_id"
                            class="block mt-1 w-full"
                            wire:model="state.task_group_id"
                            :items="json_encode($project->taskGroups->map->only('id', 'name')->toArray())"
                        />
                        <x-jet-input-error for="task_group_id" class="mt-2" />
                    </div>
                @endif

                @if ($project?->taskGroups->count())
                    <div>
                        <x-jet-label for="assignees" value="{{ __('Assignees') }}" />
                        <x-custom-multiselect
                            id="assignees"
                            class="block mt-1 w-full"
                            wire:model="state.assignees"
                            :items="json_encode($users->map->only('id', 'name', 'profile_photo_url')->toArray())"
                        />
                        <x-jet-input-error for="assignees" class="mt-2" />
                    </div>
                @endif
            </div>

            <div>
                <x-jet-label value="{{ __('Attachments') }}" />
                <div class="mt-1 border divide-y rounded-md">
                    @forelse ($task->attachments ?? [] as $attachment)
                        <div class="p-4">
                            <div class="flex items-center justify-between">
                                <p class="text-sm font-semibold text-gray-800 leading-tight">
                                    {{ $attachment->filename }} <span class="text-xs text-gray-600 font-medium">({{ round($attachment->size / 1024, 1) }} KB)</span>
                                </p>

                                <div class="flex items-center space-x-2">
                                    <x-link href="{{ $attachment->url }}" target="_blank">
                                        {{ __('View') }}
                                    </x-link>

                                    <button
                                        type="button"
                                        class="text-sm font-medium text-rose-600 hover:text-rose-500 transition"
                                        wire:click="deleteAttachment({{ $attachment->id }})"
                                    >
                                        {{ __('Delete') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-4 flex items-center justify-between">
                            <p class="text-sm text-gray-800">
                                {{ __('No attachments') }}
                            </p>
                        </div>
                    @endforelse

                    <div class="p-4">
                        <x-file-input id="file" class="block w-full" type="file" wire:model.defer="file" />
                        <x-jet-input-error for="file" class="mt-2" />
                        @if ($file)
                            <div class="mt-2 font-medium text-sm">
                                {{ __('Uploaded.') }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            @if ($this->isTarget('update'))
                <div>
                    <p class="text-xs font-medium text-gray-500">
                        Created: {{ $task?->created_at->diffForHumans() }}
                    </p>
                    <p class="text-xs font-medium text-gray-500">
                        Updated: {{ $task?->updated_at->diffForHumans() }}
                    </p>
                </div>

                <x-danger-button x-on:click="confirm('Are you sure you want to delete this?') ? $wire.delete() : null">
                    {{ __('Delete') }}
                </x-danger-button>
            @endif
        </form>

        <x-slot name="actions">
            <x-jet-button class="w-full justify-center" x-on:click="$wire.{{ $target }}()">
                {{ __(ucfirst($target)) }}
            </x-jet-button>
        </x-slot>
    </x-slideout>
</div>
