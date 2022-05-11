<div>
    @livewire('crm.prospects.form')

    @if ($items->count())
        <x-grid-list>
            @foreach ($items as $item)
                <x-prospect.item :item="$item" />
            @endforeach
        </x-grid-list>
    @else
        <x-empty-card />
    @endif
</div>
