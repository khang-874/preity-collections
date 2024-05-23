@props(['listing'])

<x-card>
    <div class="flex"> 
        <div>
            <div><x-image-gallery :listing="$listing"></x-image-gallery></div>
             <h3 class="text-2xl">
                <a href="/listings/{{$listing->id}}">{{$listing->name}}</a>
            </h3> 
            <div>CA$ {{$listing->selling_price}}</div>
        </div>
    </div>
</x-card>