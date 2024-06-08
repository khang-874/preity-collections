<x-layout>
    <x-logo></x-logo>
    <x-cart></x-cart>
    <x-navbar :categories="$categories"></x-navbar>
    <main>
        <div class="flex flex-wrap w-full gap-1 px-1 mt-6">
            @unless(count($listings) == 0)
            @foreach ($listings as $listing)
                <x-card.listing-card :listing="$listing"/>

            @endforeach
        </div>
        {{-- </div> --}}
        @else
            <p>No listings found </p>
        @endunless

        {{-- </div> --}}
        <div class="mt-6 p-4">{{$listings->links()}}</div>
    </main>
</x-layout>