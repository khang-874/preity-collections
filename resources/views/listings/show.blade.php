<x-layout>
    <header>
        <x-header :categories="$categories"></x-header>
    </header>
    <main> 
        <div class="px-2 lg:mx-[10%] lg:flex lg:flex-wrap lg:gap-2 mt-2">
            <div class='h-full md:flex-grow md:basis-[20rem]'>            
                <x-card.image-gallery class='!w-full !h-full' :listing="$listing" cover="bg-white drop-shadow-md"></x-card.image-gallery>
            </div>
            <div class="bg-white drop-shadow-md p-2 lg:flex-grow">
                <div>
                    <h4 class="w-full font-medium text-xl">{{$listing -> name}}</h4>
                    <p class="font-medium">CA$ {{$listing -> selling_price}}</p>
                </div>  
                <x-order-input :listing="$listing" :details="$listing->details"></x-order-input>                             
            </div> 
            <div class="p-2 bg-white drop-shadow-md mt-2 lg:flex-grow">
                <p class="font-semibold">Description:</p>
                <p class="text-sm">{{$listing -> description}}</p>
            </div>

            <div class="p-2 bg-white drop-shadow-md mt-2 w-full">
                <p class="font-semibold">You might like:</p>
                @mobile
                    <livewire:slideshow :items="$recommendListings" perShow="2" />
                @endmobile

                @tablet
                    <livewire:slideshow :items="$recommendListings" perShow="3" />
                @endtablet

                @desktop
                    <livewire:slideshow :items="$recommendListings" perShow="4" />
                @enddesktop 
            </div>

        </div> 
</main>
</x-layout>