<x-layout>
{{-- @include('partials._hero') --}}
{{-- @include('partials._search') --}}
<x-slot:navbar>
    @include('partials._navbar')
</x-slot>
{{-- <div class="grid space-y-4 md:space-y-0 mx-[10%] gap-8 mt-4" style="grid-template-columns: 1fr 5fr"> --}}
{{-- <div class="col-start-1 bg-red-500 "></div> --}}
<div class="flex flex-wrap w-full gap-5 px-5 mt-6">
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
</x-layout>