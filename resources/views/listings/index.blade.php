<x-layout>
    <x-logo></x-logo>
    <x-cart></x-cart>
    <x-navbar :categories="$categories"></x-navbar>
    <main>
        <div class="w-full mt-6">
            <div class="flex flex-wrap gap-1 justify-center">
                @unless(count($listings) == 0)
                @foreach ($listings as $listing)
                    <x-card.listing-card :listing="$listing"/>

                @endforeach
            </div>
        </div>
        {{-- </div> --}}
        @else
            <p>No listings found </p>
        @endunless

        {{-- </div> --}}
        <div class="mt-6 p-4">{{$listings->links()}}</div>
    </main>
</x-layout>