@props(['listing'])

<x-card>
    <x-card.image-gallery :listing="$listing" cover=""></x-image-gallery>
    <a href="/listings/{{$listing->id}}" ><p class="w-[95%] text-sm pl-2 font-bold text-nowrap overflow-hidden">{{$listing->name}}</p></a>
    <p class="text-md pl-2">CA$ {{$listing->selling_price}}</p>
    @auth
        <a href="/listings/{{$listing->id}}/edit" class="mb-4">Edit</a>
    @endauth
</x-card>