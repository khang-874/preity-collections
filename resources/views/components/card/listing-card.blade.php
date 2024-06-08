@props(['listing'])

<x-card>
    <img src="{{$listing->imageURL}}" alt="" class="h-[70%] object-center">
    <a href="/listings/{{$listing->id}}" ><p class="w-[95%] text-sm pl-2 pt-2 text-nowrap overflow-hidden">{{$listing->name}}</p></a>
    <p class="text-lg pl-2 font-medium">CA$ {{$listing->selling_price}}</p>
    @auth
        <a href="/listings/{{$listing->id}}/edit" class="mb-4">Edit</a>
    @endauth
</x-card>