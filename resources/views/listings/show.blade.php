<x-layout>
<x-slot:navbar>
@include('partials._navbar')
</x-slot>
    <div class="mx-[20%] mt-4">
        <x-card class='grid grid-cols-2 gap-4' x-data="{color: '', size: '', currentVal: 1, minVal: 0, decimalPoints: 0, incrementAmount: 1}">

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
                <x-counter></x-counter>
                <p>{{$listing -> description}}</p>
                <button x-data @click="$store.cart.addToCart({
                   'listingId' : {{$listing->id}},
                   'color' : color,
                   'size' : size, 
                   'quantity' : currentVal,
                   'imageURL' : '{{$listing -> details -> first() -> images -> first() -> imageURL}}',
                })">Add to cart</button>
            </div>
        </x-card>
    </div>
    {{-- <a href="/">Return</a> --}}
</x-layout>