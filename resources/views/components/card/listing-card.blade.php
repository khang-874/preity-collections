@props(['listing'])

<x-card class="relative">
    <div class="h-[75%] lg:h-[80%] overflow-hidden"><img src="{{$listing->details->first() -> images-> first()-> imageURL}}" alt="" class="h-full min-w-full"></div>
    <a href="/listings/{{$listing->id}}" ><p class="w-[95%] text-sm pl-2 pt-2 text-nowrap overflow-hidden">{{$listing->name}}</p></a>
    <p class="text-lg pl-2 font-medium">CA$ {{$listing->selling_price}}</p>
    @auth
        <a href="/listings/{{$listing->id}}/edit" class="absolute top-0 left-0 bg-white flex gap-2 items-center">
            <i class="fa-regular fa-pen-to-square"></i>Edit
        </a>
    @endauth
</x-card>