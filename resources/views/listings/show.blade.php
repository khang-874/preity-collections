<x-layout :categories="$categories"> 
    <div class="max-w-screen-xl mx-auto p-6">
        <div class="flex flex-col lg:flex-row items-center bg-white shadow-lg rounded-lg overflow-hidden">
            <div class='lg:w-1/2 p-4 container'>            
                <x-card.image-gallery :listing="$listing" cover="bg-white drop-shadow-md"></x-card.image-gallery>
            </div>
            <div class="lg:w-1/2 p-4 container">
                <h4 class="w-full font-medium text-2xl">{{$listing -> name}}</h4>
                @if ($listing -> sale_percentage != 0)
                    <div class="flex items-center gap-1 sm:gap-2 sm:flex-row-reverse sm:justify-end">
                        <div class="flex">
                            <p class="text-xl font-medium text-red-500">CA$ {{$listing->selling_price}}</p> 
                            <p class="hidden text-xl font-medium text-red-500 md:block">({{round($listing->sale_percentage)}}% off)</p>
                        </div>
                        <p class="text-base font-medium line-through">CA$ {{$listing->base_price}}</p>  
                    </div>
                @else
                    <p class="font-medium text-xl mt-2">CA$ {{$listing -> selling_price}}</p>
                @endif

                <x-order-input :listing="$listing" :sizes="$sizes" :colors="$colors"></x-order-input>
                {{-- <livewire:product-selector-component :listing="$listing"/> --}}

                <div x-data="{show : false}" class="mt-4">
                    <div @click="show = !show" class="flex justify-between items-center cursor-pointer">
                        <p class="uppercase font-medium text-sm">Description</p>
                        <i x-show="!show" class="fa-solid fa-plus"></i>
                        <i x-show="show" class="fa-solid fa-minus"></i>
                    </div>
                    <div    x-show="show"
                            x-transition:enter="transition linear duration-[50ms] transform"
                            x-transition:enter-start="opacity-0"
                            x-transition:enter-end="opacity-100"
                            x-transition:leave="transition linear duration-[50ms]"
                            x-transition:leave-start="opacity-100"
                            x-transition:leave-end="opacity-0"
                            x-cloak 
                            >
                            <p class="text-sm w-3/5">{{$listing -> description}}</p> 
                    </div>
                </div>
            </div> 
        </div>  
    </div> 

    {{-- Divider  --}}
    <div class="h-[1px] w-screen bg-slate-100 mb-4 mt-8">
    </div>

    <div class="md:max-w-[50%] mx-auto">
        <livewire:slideshow :items="$recommendListings" type="listing" title="You might also like"/>
    </div>
</x-layout>