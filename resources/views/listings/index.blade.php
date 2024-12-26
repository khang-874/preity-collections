<x-layout :categories="$categories">
    <div class="mt-2 mx-auto container"> 
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
            <div class="hidden lg:block basis-[15rem] bg-white h-full ml-4"> 
                <livewire:filters :options="$stdSizes" property="size" :isBorder="true"/>
                <livewire:filters :options="$stdColors" property="color" :isBorder="false"/>
            </div>
            <div class="flex-grow-[9999]">
                <x-layouts.index-title :listings_number="$listings_number"></x-layouts.index-title>
                <div class="grid gap-1 md:gap-2  items-center mx-auto grid-cols-[repeat(auto-fit,_minmax(9rem,_1fr))] sm:grid-cols-[repeat(auto-fit,_minmax(12rem,_1fr))] md:grid-cols-[repeat(auto-fit,_minmax(14rem,_1fr))]">
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
    </div>
</x-layout>