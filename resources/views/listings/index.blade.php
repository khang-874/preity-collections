<x-layout :categories="$categories">
    <main class="mt-2 max-w-[80%] mx-auto"> 
        @php
            // dd($listings)
            $stdColors = [];
            $stdSizes = [];
            foreach ($colors as $color) {
                $stdColors[] = $color -> color;
            }
            foreach ($sizes as $size) {
                $stdSizes[] = $size -> size;
            }
        @endphp
        <div class="flex gap-6"> 
            <div class="hidden md:block basis-[15rem] flex-grow bg-white h-full ml-[2%] p-2 "> 
                <livewire:filters :options="$stdSizes" property="size"/>
                <livewire:filters :options="$stdColors" property="color"/>
            </div>
            <div class="flex-grow-[9999] pr-[2%]">
                <x-layouts.index-title></x-layouts.index-title>
                <div class="grid gap-2 " style="grid-template-columns: repeat(auto-fit, minmax(min(16rem,100%), 1fr))">
                    @unless(count($listings) == 0)
                        @foreach ($listings as $listing)
                            @if ($listing -> available == true)
                                <x-card.listing-card :item="$listing" type="listing"/>
                            @endif
                        @endforeach
                    @else
                        <p>No listings found </p>
                    @endunless
                </div>
            </div>
        </div>
        @if(method_exists($listings, "links")) 
            <div class="mt-6 p-4">{{$listings->links()}}</div>
        @endif 
    </main>
</x-layout>