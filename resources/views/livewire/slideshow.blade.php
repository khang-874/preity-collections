<div class="relative overflow-y-hidden">
    <button wire:click="moveLeft" class="p-2 bg-white fixed top-[40%] left-0 text-black drop-shadow-md z-10"><</button>
    <div class="flex gap-2 items-center justify-center">
        @foreach ($currentItems as $item)
        <x-card.listing-card :listing="$item"></x-card.listing-card>
        @endforeach
    </div>
    <button wire:click="moveRight" class="p-2 bg-white fixed top-[40%] right-0 text-black drop-shadow-md z-10">></button> 
</div>
