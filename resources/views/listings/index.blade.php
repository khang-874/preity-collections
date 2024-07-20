<x-layout>
    <x-logo></x-logo>
    <x-cart></x-cart>
    <x-navbar-large :categories="$categories"></x-navbar-large>
    <x-navbar :categories="$categories"></x-navbar>
    <main>
        
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
            <div class="hidden lg:block basis-2/12 flex-grow bg-white h-full pl-[2%]">
                <x-filters :items="$stdSizes" property="size"></x-filters>
                <x-filters :items="$stdColors" property="color"></x-filters>
            </div>
            <div class="lg:w-10/12">
                <x-layouts.index-title></x-layouts.index-title>
                <div class="flex flex-wrap gap-1">
                    @unless(count($listings) == 0)
                        @foreach ($listings as $listing)
                            @if ($listing -> available == true)
                                <x-card.listing-card :listing="$listing"/>
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