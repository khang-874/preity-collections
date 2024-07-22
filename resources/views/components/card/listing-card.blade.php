@props(['listing'])

@php
    // dd($listing -> images[0]);
    // if(sizeof($listing -> images) == 0)
    //     dd($listing);
@endphp
<a class="cursor-pointer" href="/listings/{{$listing->id}}" >
    <x-card class="relative">
        @php
            $showingImage = $listing -> images[0] ?? '';
            if(Storage::exists($showingImage))
                $showingImage = Storage::url($showingImage);
        @endphp
        <div class="h-[75%] lg:h-[80%] overflow-hidden"><img src="{{$showingImage}}" alt="" class="h-full min-w-full"></div>
        <p class="w-[95%] text-xs pl-2 pt-2 text-nowrap overflow-hidden">{{$listing->name}}</p>
        <p class="text-sm pl-2 font-medium">CA$ {{$listing->selling_price}}</p> 
    </x-card>
</a>