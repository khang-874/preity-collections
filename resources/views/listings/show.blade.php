<x-layout>
    <header>
        <x-header :categories="$categories"></x-header>
    </header>
    <main> 
        <div class="md:mx-auto mt-4 md:max-w-[50%]">
			<div class="flex gap-4 flex-wrap">
				<div class=''>            
					<x-card.image-gallery :listing="$listing" cover="bg-white drop-shadow-md"></x-card.image-gallery>
				</div>
				<div class="flex-grow basis-1">
					<div>
						<h4 class="w-full font-medium text-2xl">{{$listing -> name}}</h4>
						<p class="font-medium text-xl">CA$ {{$listing -> selling_price}}</p>
					</div>  
					<x-order-input :listing="$listing" :details="$listing->details"></x-order-input>                             

                    <div x-data="{show : false}" class="mt-10">
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
            <div class="h-[1px] w-screen bg-slate-100 mb-4 mt-8">
            </div>
        <div class="md:max-w-[50%] mx-auto">
            <livewire:slideshow :items="$recommendListings" type="listing" title="You might also like"/>
        </div>

</main>
</x-layout>