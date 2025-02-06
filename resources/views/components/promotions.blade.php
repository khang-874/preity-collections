@props(["promotions"])


@php
    $promotion = null;
    foreach($promotions as $item)    
        if($item -> isShow){
            $promotion = $item;
        }
@endphp
<section class="">
    <!-- Left Side - Text Area --> 
    <div    x-data = "{activeSlide: 0}" x-init="$nextTick(() => {
            setInterval(() => {
                activeSlide++;
                if(activeSlide == {{$promotion == null ? 1 : 2}})
                    activeSlide = 0;
            }, 4000) 
        })"
        class="relative w-full h-auto">
    
        <a x-show="activeSlide == 0" href="{{url('/listings/clearance')}}">
            <img src="{{url('/images/background.png')}}" alt="Clearance promotion" class='w-full'> 
        </a>   
        @if ($promotion != null)
            <a x-show="activeSlide == 1" href="{{url('/listings/sale')}}">
                <img src="{{$item -> getDisplayImage()}}" alt="Sale promotion" class='w-full'> 
            </a>       
        @endif
        

        <div class="absolute border-[1px] border-black rounded-full bottom-2 right-8 md:right-10 size-3 md:size-4" @click="activeSlide = 0" :class="activeSlide == 0 ? 'bg-primary' : 'bg-white'"></div>
        
        @if($promotion != null)
            <div class="absolute border-[1px] border-black rounded-full bottom-2 right-4 size-3 md:size-4" @click="activeSlide = 1" :class="activeSlide == 1 ? 'bg-primary' : 'bg-white'"></div>
        @endif
    </div>
</section>
