<x-layout>
    <header>
        <x-header :categories="$categories"></x-header>
    </header>
    <main> 
        <div class="px-2 lg:mx-[10%] lg:grid lg:grid-cols-2 lg:gap-2 mt-2">
            <div class='h-full place-self-center'>            
                <x-card.image-gallery class='!w-full !h-full' :listing="$listing" cover="bg-white drop-shadow-md"></x-card.image-gallery>
            </div>
            <div class="bg-white drop-shadow-md p-2 h-full">
                <div>
                    <h4 class="w-full font-medium text-xl">{{$listing -> name}}</h4>
                    <p class="font-medium">CA$ {{$listing -> selling_price}}</p>
                </div>  
                <x-order-input :listing="$listing" :details="$listing->details"></x-order-input>                             
            </div> 
            <div class="p-2 bg-white drop-shadow-md mt-2 lg:col-span-full">
                <p class="font-semibold">Description:</p>
                <p class="text-sm">{{$listing -> description}}</p>
            </div>

            <div class="p-2 bg-white drop-shadow-md mt-2 lg:col-span-full">
                <livewire:slideshow :items="$recommendListings" type="listing" title="You might like"/>
            </div>

        </div> 
</main>
</x-layout>