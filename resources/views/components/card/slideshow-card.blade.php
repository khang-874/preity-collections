@props(['item'])

<a class="cursor-pointer relative block" href="{{$item -> link}}">
    <div class="relative">
        @php 
            $showingImage = $item -> images[0] ?? '';
            if(Storage::exists($showingImage))
                $showingImage = Storage::url($showingImage);
        @endphp
        <div><img src="{{ $showingImage }}" alt="{{ $item['name'] }}" class="w-full object-cover h-52 md:h-80 object-top"></div>
        <div class="bg-white text-center text-base md:text-lg"> 
            <h2 class="font-bold">{{$item -> name}}</h2>
            <p class="text-sm md:text-lg text-[#7e246e] font-normal">SHOP NOW</p>
        </div>    
    </div>
</a>