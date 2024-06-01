<x-layout>
<x-slot:navbar>
@include('partials._navbar')
</x-slot>
    <div class="mx-[10%] mt-4">
        <div x-data="{color: '{{$listing->details->first() -> color}}', size: '{{$listing->details->first()->size}}', quantity:1}">
            @php
                $count = 0;
            @endphp
            <div class='col-start-1 h-full'>            
                <x-card.image-gallery class='!w-full !h-full' :listing="$listing" cover="bg-white drop-shadow-md p-2 h-60 mb-2"></x-card.image-gallery>
            </div>
            <div>
                <div class="bg-white drop-shadow-md p-2">
                    <h4 class="w-full font-semibold">{{$listing -> name}}</h4>
                    <div class="flex gap-x-4">  
                        <div class="flex-grow">
                            <p>Size</p> 
                            <select name="size" id="size-id" x-model="size" class="w-full">
                                @foreach ($listing -> details as $detail) 
                                    <option value="{{$detail->size}}">{{$detail->size}}</option> 
                                @endforeach 
                            </select>
                        </div>
                        <div class="flex-grow">
                            <p>Color</p>
                            <select name="size" id="size-id" x-model="color" class="w-full">
                                @foreach ($listing -> details as $detail)    
                                    <option value="{{$detail->color}}">{{$detail->color}}</option> 
                                @endforeach 
                            </select>
                        </div>
                    </div>
                </div>
                <div class="p-2 bg-white drop-shadow-md mt-2">
                    <p class="font-semibold">Description:</p>
                    <p>{{$listing -> description}}</p>
                </div>
                <p class="p-2 bg-white drop-shadow-md font-medium mt-2">CA$ {{$listing -> selling_price}}</p>
                <div class="p-2 bg-white drop-shadow-md mt-2">
                    <label for="quantity" class="font-semibold">Quantity:</label>
                    <input type="number" x-model.number="quantity" id="quantity"/>
                </div>
                <button x-data @click="$store.cart.addToCart({
                   'listingId' : {{$listing->id}},
                   'name' : '{{$listing->name}}',
                   'color' : color,
                   'size' : size, 
                   'quantity' : quantity,
                   'price' : {{$listing->selling_price}},
                   'imageURL' : '{{$listing -> details -> first() -> images -> first() -> imageURL}}',
                })"
                    class="p-2 bg-black rounded-md font-medium text-white mt-2"
                >Add to cart</button>
            </div>
        </div>
    @auth
        <a href="/listings/{{$listing->id}}/edit" class="mb-4"><x-button>Edit</x-button></a>
    @endauth

    </div>
       {{-- <a href="/">Return</a> --}}
</x-layout>