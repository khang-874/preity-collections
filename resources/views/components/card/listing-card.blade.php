@props(['listing'])

<x-card>
    <x-card.image-gallery :listing="$listing" cover=" "></x-image-gallery>
    <p class="text-sm pl-2 font-bold">
        <a href="/listings/{{$listing->id}}">{{$listing->name}}</a>
    </p> 
    <p class="text-md pl-2">CA$ {{$listing->selling_price}}</p>
</x-card>