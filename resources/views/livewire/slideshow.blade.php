@props(['currentItems', 'title', 'type'])

<div class="w-full mx-auto">
    <!-- Section Title -->
    <p class="font-semibold text-xl text-primary text-center uppercase w-full my-2">{{ $title }}:</p>
    <div class="relative">
        <!-- Left Arrow -->
        <button wire:click="moveLeft" class="p-2 bg-white absolute top-[40%] -left-2 text-black drop-shadow-md z-10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        <!-- Cards -->
        <div class="overflow-x-auto">
            <div class="grid gap-4" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr))">
                @foreach ($currentItems as $item)
                    @if ($type == 'listing')
                        <x-card.listing-card :item="$item"></x-card.slideshow-card>
                    @else
                        <x-card.slideshow-card :item="$item"></x-card.slideshow-card>
                    @endif
                @endforeach
            </div>
        </div>

        <!-- Right Arrow -->
        <button wire:click="moveRight" class="p-2 bg-white absolute top-[40%] -right-2 text-black drop-shadow-md z-10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
</div>