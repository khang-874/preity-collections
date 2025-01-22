@props(['currentItems', 'title', 'type'])

<div class="w-full">
    <!-- Section Title -->
    <p class="font-semibold text-base md:text-xl text-primary text-center uppercase w-full my-2">{{ $title }}</p>
    <div class="relative mx-auto">
        <!-- Left Arrow -->
        <button wire:click="moveLeft" class="p-1 bg-white absolute top-[40%] -left-2 text-black drop-shadow-md z-10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        <!-- Cards -->
        {{-- <div class="grid gap-1 md:gap-2
            grid-cols-[repeat(auto-fit,_minmax(8rem,_1fr))] sm:grid-cols-[repeat(auto-fit,_minmax(12rem,_1fr))] md:grid-cols-[repeat(auto-fit,_minmax(14rem,_1fr))]"> --}}
        <div class="flex gap-1 md:gap-2 justify-center">
            @foreach ($currentItems as $item)
                @if ($type == 'listing')
                    {{-- <x-card.listing-card :item="$item" type="listing"></x-card.listing-card> --}}
                    <x-card.listing-card :item="$item"/>
                @else
                    <x-card.slideshow-card :item="$item"></x-card.slideshow-card>
                @endif
            @endforeach
        </div>

        <!-- Right Arrow -->
        <button wire:click="moveRight" class="p-1 bg-white absolute top-[40%] -right-2 text-black drop-shadow-md z-10">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-6 h-6">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
</div>