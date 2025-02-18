@props(["promotions"])


@php
    $idx = 0; 
    $cnt = 0;
    foreach($promotions as $promotion){
        if($promotion -> isShow)
            $cnt++;
    }
@endphp
<section class="">
    <!-- Left Side - Text Area --> 
    <!-- Their will be always one default promotion for clearance that's why we will have it plus one -->
    <div    x-data = "{activeSlide: 0}" x-init="$nextTick(() => {
            setInterval(() => {
                activeSlide++;
                if(activeSlide == {{$cnt + 1}})
                    activeSlide = 0;
            }, 4000) 
        })"
        class="relative w-full h-auto">
    
        @foreach ($promotions as $promotion)
            @if($promotion -> isShow)
                <a x-show="activeSlide == {{$idx++}}" href="{{url('/listings/events/' .  $promotion -> event)}}">
                    <img src="{{$promotion -> getDisplayImage()}}" alt="Sale Promotion" class='w-full'> 
                </a>  
            @endif
        @endforeach

        <a x-show="activeSlide == {{$cnt}}" href="{{url('/listings/clearance')}}">
            <img src="{{url('/images/background.png')}}" alt="Clearance promotion" class='w-full'> 
        </a>    

        <div class="absolute bottom-2 right-4 flex space-x-2">
        @for ($i = 0; $i <= $cnt; $i++)
            <div class="border-[1px] border-black rounded-full size-3 md:size-4" @click="activeSlide = {{$i}}" 
            :class="activeSlide == {{$i}} ? 'bg-primary' : 'bg-white'"></div>
        @endfor
        </div>
        
    </div>
</section>
