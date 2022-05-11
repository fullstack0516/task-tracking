<div class="grid md:grid-cols-3 gap-6">
    <x-card class="flex items-center justify-between">
        <div>
            <div class="flex items-center space-x-3">
                <h3 class="text-gray-900 text-sm font-medium truncate">
                    {{ __('Prospects') }}
                </h3>
            </div>
            <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $prospects }}</p>
        </div>
        <div class="flex items-center space-x-3">
            <x-link href="{{ route('crm.prospects.index') }}">
                <x-heroicon-o-eye class="h-6 w-6 text-accent opacity-20 hover:opacity-100" />
            </x-link>
        </div>
    </x-card>
    <x-card class="flex items-center justify-between">
        <div>
            <div class="flex items-center space-x-3">
                <h3 class="text-gray-900 text-sm font-medium truncate">
                    {{ __('Clients Won') }}
                </h3>
            </div>
            <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $wins }}</p>
        </div>
    </x-card>
    <x-card class="flex items-center justify-between">
        <div>
            <div class="flex items-center space-x-3">
                <h3 class="text-gray-900 text-sm font-medium truncate">
                    {{ __('Client(s) Lost') }}
                </h3>
            </div>
            <p class="mt-1 text-3xl font-semibold text-gray-900">{{ $lost }}</p>
        </div>
    </x-card>
</div>
