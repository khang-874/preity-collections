<x-layout>
    <x-logo></x-logo>
    <x-cart></x-cart>
    <x-navbar :categories="$categories"></x-navbar>
       <main> 
            <div class="px-2 lg:mx-[10%] lg:flex lg:flex-wrap lg:gap-2 mt-2">
                <div class='h-full lg:flex-grow lg:basis-[50%]'>            
                    <x-card.image-gallery class='!w-full !h-full' :listing="$listing" cover="bg-white drop-shadow-md"></x-card.image-gallery>
                </div>
                <div class="bg-white drop-shadow-md p-2 lg:flex-grow lg:basis-[45%]">
                    <div>
                        <h4 class="w-full font-medium text-2xl">{{$listing -> name}}</h4>
                        <p class="font-medium text-xl">CA$ {{$listing -> selling_price}}</p>
                    </div>  
                    <x-order-input :listing="$listing" :details="$listing->details"></x-order-input>                             
                </div> 
                <div class="p-2 bg-white drop-shadow-md mt-2 lg:flex-grow">
                    <p class="font-semibold">Description:</p>
                    <p>{{$listing -> description}}</p>
                </div>
            </div>
            

        @auth
            <a href="/listings/{{$listing->id}}/edit" class="mb-4"><x-button>Edit</x-button></a> 
            <x-form.delete-button url="/listings/{{$listing->id}}" name="Delete listing"/>
        @endauth

    {{-- <a href="/">Return</a> --}}
    </main>
</x-layout>