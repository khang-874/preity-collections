<x-layout>
@include('partials._navbar')
    <div class="mx-[20%] mt-4">
        <x-card class='grid grid-cols-2 gap-4' x-data="{color: '', size: ''}">

            @php
                $count = 0;
            @endphp
            <div class='col-start-1 h-full'>            
                <x-image-gallery class='!w-full !h-full' :listing="$listing"></x-image-gallery>
            </div>
            <div>
                <h4 class="w-full">{{$listing -> name}}</h4>
                <p>Size</p>
                <ul class= 'flex flex-wrap gap-2'>
                    @foreach ($listing -> details as $detail)
                    <li>
                        <input type="radio" name="size" id="{{$detail -> size}}" value="{{$detail->size}}" x-data x-model="size" required>
                        <p>{{$detail -> size}}</p> 
                    </li>
                    @endforeach
                </ul>
                <p>Color</p>
                <ul class= 'flex flex-wrap gap-2'>
                    @foreach ($listing -> details as $detail)
                    <li>
                        <input type="radio" value="{{$detail -> color}}" id="{{$detail -> color}}" name="color" x-data x-model="color" required>
                        <p>{{$detail -> color}}</p>
                    </li>
                    @endforeach
                </ul>
                <p>{{$listing -> description}}</p>
                <button x-data @click="$store.storing.addToCart({
                   'listingId' : {{$listing->id}},
                   'color' : color,
                   'size' : size, 
                })">Add to cart</button>
            </div>
        </x-card>
    </div>
    {{-- <a href="/">Return</a> --}}
</x-layout>