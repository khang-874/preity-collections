@props(['listing'])

@php
    // dd($listing -> images[0]);
    // if(sizeof($listing -> images) == 0)
    //     dd($listing);
@endphp
<x-card class="relative">
    <div class="h-[75%] lg:h-[80%] overflow-hidden"><img src="{{$listing->images[0] ?? ''}}" alt="" class="h-full min-w-full"></div>
    <a href="/listings/{{$listing->id}}" ><p class="w-[95%] text-sm pl-2 pt-2 text-nowrap overflow-hidden">{{$listing->name}}</p></a>
    <p class="text-lg pl-2 font-medium">CA$ {{$listing->selling_price}}</p> 
</x-card>