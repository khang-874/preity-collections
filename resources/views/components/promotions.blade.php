<section class="grid grid-cols-3 justify-between p-10 items-center"
        style='background-image: url("{{url('/images/background.png')}}");
                background-size: cover;
                background-position: center'>
    <!-- Left Side - Text Area -->
    <div class="col-span-2">
        <h2 class="text-6xl uppercase font-bold text-primary">New Year Sale</h2>
        <p class="text-xl mt-4">Explore our premium collection at amazing prices. Get up to 50% off on selected items!</p>
        <a href="/listings/" class="inline-block mt-6 px-6 py-3 bg-primary text-white text-lg rounded-lg hover:bg-purple-800 transition">Shop Now</a>
    </div>
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
        <div x-show="activeSlide=={{$key}}">
            <x-card.listing-card :item="$promotion->listing"></x-card.listing-card>
        </div>
    @endforeach 
</section>
