<div class="w-fit max-w-full mx-auto">
    <p class="font-semibold text-lg text-center w-full mb-2">{{$title}}:</p>
    <div class="relative">
        <button wire:click="moveLeft" class="p-2 bg-white absolute top-[40%] left-0 text-black drop-shadow-md z-10"><</button>
        <div class="">
            <div class="flex gap-2 items-center justify-center">
                @foreach ($currentItems as $item)
                    <x-card.listing-card :item="$item" :type="$type"></x-card.listing-card>
                @endforeach
            </div>
        </div>
        <button wire:click="moveRight" class="p-2 bg-white absolute top-[40%] right-0 text-black drop-shadow-md z-10">></button> 
    </div>
</div>
