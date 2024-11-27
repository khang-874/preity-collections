@props(['item'])

<a class="cursor-pointer relative block" href="{{$item -> link}}">
    <div class="relative">
        @php 
            $showingImage = $item -> images[0] ?? '';
            if(Storage::exists($showingImage))
                $showingImage = Storage::url($showingImage);
        @endphp
        <div><img src="{{ $showingImage }}" alt="{{ $item['name'] }}" class="w-full object-cover h-[20rem] lg:h-[26rem] object-top"></div>
        <div class="bg-white">
            <!-- Responsive SVG Curve -->
            {{-- <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" class="w-full h-20">
                <path fill="white" d="M0,128L48,138.7C96,149,192,171,288,181.3C384,192,480,192,576,186.7C672,181,768,171,864,181.3C960,192,1056,224,1152,218.7C1248,213,1344,171,1392,149.3L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg> --}}

            <!-- Text Content -->
            <div class="absolute bottom-0 w-full bg-white text-center py-4">
                <h2 class="text-lg font-bold">{{$item -> name}}</h2>
                <p class="text-[#7e246e] font-normal">SHOP NOW</p>
            </div>
        </div>    
    </div>
</a>