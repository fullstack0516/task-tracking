@unless ($breadcrumbs->isEmpty())
    <nav class="flex" aria-label="Breadcrumb">
        <ol role="list" class="flex items-center md:space-x-4">
            @foreach ($breadcrumbs as $breadcrumb)
                @if ($breadcrumb->url && !$loop->last)
                    <li class="hidden md:flex">
                        <div class="flex items-center">
                            @unless($loop->first)
                                <x-heroicon-s-chevron-right class="mr-4 flex-shrink-0 h-5 w-5 text-gray-400" />
                            @endunless
                            <a href="{{ $breadcrumb->url }}" class="text-sm font-medium text-gray-500 dark:text-white hover:text-gray-700">
                                {{ $breadcrumb->title }}
                            </a>
                        </div>
                    </li>
                @else
                    <li class="hidden md:flex">
                        <div class="flex items-center">
                            @unless($loop->first)
                                <x-heroicon-s-chevron-right class="mr-4 flex-shrink-0 h-5 w-5 text-gray-400" />
                            @endunless
                            <span class="text-sm font-medium text-gray-500 dark:text-white">
                                {{ $breadcrumb->title }}
                            </span>
                        </div>
                    </li>
                @endif

                @if ($loop->last)
                    <li class="flex md:hidden">
                        <span class="text-sm font-medium text-gray-500 dark:text-white">
                            {{ $breadcrumb->title }}
                        </span>
                    </li>
                @endif
            @endforeach
        </ol>
    </nav>
@endunless
