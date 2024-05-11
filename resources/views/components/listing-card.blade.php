@props(['listing'])

<x-card>
    <div class="flex">
        <img
            class="hidden w-48 mr-6 md:block"
            src="{{asset('images/no-image.png');}}"
            alt=""
        />
        <div>
            <h3 class="text-2xl">
                <a href="/listings/{{$listing->id}}">{{$listing->name}}</a>
            </h3>

            @foreach ($listing->details as $detail)
                @foreach ($detail->images as $image)
                    <img src="{{$image->imageURL}}"/>
                @endforeach
            @endforeach

            <div class="text-xl font-bold mb-4">{{$listing->description}}</div>

            {{-- <x-listing-tags :tagsCsv="$listing->tags" /> --}}
                
            {{-- <div class="text-lg mt-4">
                <i class="fa-solid fa-location-dot"></i> 
                {{$listing->location}}
            </div> --}}
            <div>{{$listing->price}}</div>
        </div>
    </div>
</x-card>