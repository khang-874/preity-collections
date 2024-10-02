@props(['currentItems', 'title'])
<div class="w-full mx-auto">
    <p class="font-semibold text-lg text-center text-primary uppercase w-full mb-2">{{$title}}:</p>
    <div class="relative">
        <button wire:click="moveLeft" class="p-2 bg-white absolute top-[40%] -left-2 text-black drop-shadow-md z-10"></button>
        <div class="">
            <div class="grid gap-1" style="grid-template-columns: repeat(auto-fit, minmax(min(0rem, 100%), 1fr))">
                @foreach ($currentItems as $item)
                    <x-card.listing-card :item="$item" :type="$type"></x-card.listing-card>
                @endforeach
            </div>
        </div>
        <button wire:click="moveRight" class="p-2 bg-white absolute top-[40%] -right-2 text-black drop-shadow-md z-10">></button> 
    </div>
</div>
