<div>
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('crm.dashboard') }}
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        <livewire:crm.dashboard.stats />
        <livewire:crm.dashboard.chart />
        <livewire:crm.dashboard.activity />
    </div>
</div>
