@props(['listing'])

<x-card>
    <x-card.image-gallery :listing="$listing" cover=" "></x-image-gallery>
    <a href="/listings/{{$listing->id}}" class="w-full text-sm pl-2 font-bold text-nowrap">{{$listing->name}}</a>
    <p class="text-md pl-2">CA$ {{$listing->selling_price}}</p>
    @auth
        <a href="/listings/{{$listing->id}}/edit" class="mb-4">Edit</a>
    @endauth
</x-card>