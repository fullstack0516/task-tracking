<x-app-layout>
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('dashboard') }}
    </x-slot>

    @livewire('tasks.form')

    @livewire('events.form')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-12">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-3 order-1">
                @livewire('dashboard.calendar')
            </div>

            <div class="lg:col-span-6 order-3 lg:order-2">
                @livewire('dashboard.feed')
            </div>

            <div class="lg:col-span-3 order-2 lg:order-3">
                @livewire('dashboard.tasks')
            </div>
        </div>
    </div>
</x-app-layout>
