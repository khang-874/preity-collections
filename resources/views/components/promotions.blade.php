{{-- @props(['promotions'])
<div class="mx-auto md:max-w-[60%] mt-6 mb-4">
    <div    x-data = "{activeSlide: 0}" x-init="$nextTick(() => {
                console.log('here');
                console.log(activeSlide);
                setInterval(() => {
                    activeSlide++;
                    if(activeSlide == {{count($promotions)}})
                        activeSlide = 0;
                }, 4000) 
            })"
            class="relative w-full h-auto">
        @foreach ($promotions as $key => $promotion)
            @php
                $image = $promotion -> listing -> images[0];    
            @endphp
            <a x-cloak x-show="activeSlide === {{$key}}"
                href="/listings/{{$promotion -> listing -> id}}"
                    class = 'w-full grid gap-2 items-center' style="grid-template-columns: 3fr 2fr">
                    @if (Storage::exists($image)) 
                        <img x-cloak src='{{Storage::url($image)}}' class=' max-h-[22rem] w-full object-cover object-center'/>
                    @else 
                        <img x-cloak src='{{$image}}' class='max-h-[22rem] w-full object-cover object-center'/>
                    @endif 
                    <div class="flex-grow-0">
                        <div class="font-semibold">{{$promotion -> text}}</div>
                        <div class="">{{$promotion -> listing -> name}}</div>
                        @if ($promotion -> listing -> sale_percentage != 0)
                            <div class="">
                                <div class="flex items-center gap-2">
                                    <p class="text-sm font-medium text-red-500">CA$ {{$promotion -> listing -> selling_price}}</p> 
                                    <p class="text-xs font-medium line-through">CA$ {{$promotion -> listing -> base_price}}</p> 
                                </div>
                                <p class="text-sm font-medium text-red-500">{{round($promotion -> listing -> sale_percentage)}}% off</p> 
                            </div>
                        @else
                            <p class="text-sm font-medium">CA$ {{$promotion -> listing -> selling_price}}</p> 
                        @endif 
                    </div> 
            </a>   
        @endforeach 
    </div>
</div> --}}
<section class="bg-[#fdf4f7] text-[#7e246e] p-10 text-center">
    <h2 class="text-4xl font-bold mb-4">Discover Stunning Indian Clothing</h2>
    <p class="text-lg">Explore a blend of tradition and elegance with our premium collection.</p>
    <button class="mt-6 bg-[#b6246d] px-8 py-3 rounded-md text-white hover:bg-[#7e246e]">Shop Now</button>
</section>