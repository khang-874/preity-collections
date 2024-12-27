<section class="">
    <!-- Left Side - Text Area --> 
    <div    x-data = "{activeSlide: 0}" x-init="$nextTick(() => {
            console.log('here');
            console.log(activeSlide);
            setInterval(() => {
                activeSlide++;
                if(activeSlide == 2)
                    activeSlide = 0;
            }, 4000) 
        })"
        class="relative w-full h-auto">
    
        <a x-show="activeSlide == 0" href="{{url('/listings/clearance')}}">
            <img src="{{url('/images/background.png')}}" alt="Clearance promotion" class='w-full'> 
        </a>
        <a x-show="activeSlide == 1" href="{{url('/listings/sale')}}">
            <img src="{{url('/images/background-1.png')}}" alt="Sale promotion" class='w-full'> 
        </a>

        <div class="absolute border-[1px] border-black rounded-full bottom-2 right-8 md:right-10 size-3 md:size-4" @click="activeSlide = 0" :class="activeSlide == 0 ? 'bg-primary' : 'bg-white'"></div>
        <div class="absolute border-[1px] border-black rounded-full bottom-2 right-4 size-3 md:size-4" @click="activeSlide = 1" :class="activeSlide == 1 ? 'bg-primary' : 'bg-white'"></div>
    </div>
</section>
