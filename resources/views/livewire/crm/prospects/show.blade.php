<div>
    <x-slot name="breadcrumbs">
        {{ Breadcrumbs::render('crm.prospects.show', $prospect) }}
    </x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <div class="lg:col-span-9">
                <x-card>
                    @livewire('crm.prospects.communication', ['prospect' => $prospect])
                </x-card>
            </div>

            <div class="lg:col-span-3">
                <x-card>
                    <div class="border-2 border-dashed rounded-lg h-full min-h-[18rem]"></div>
                </x-card>
            </div>
        </div>
    </div>
</div>
