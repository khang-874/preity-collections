<x-layout>
    <x-logo></x-logo>
    <x-cart></x-cart>
    <x-navbar :categories="$categories"></x-navbar>
    @php
        $count = 0;
        $availableOption = [];
        foreach($listing -> details as $detail)
                $availableOption[]=  array(
                    "detailId" => $detail -> id,
                    "color" => $detail -> color,
                    "size" => $detail -> size,
                    "available" => $detail -> available
                );
    @endphp

    <main>
        <div class="mx-[10%] mt-4">
            <div x-data="{
                color: '{{$listing->details->first() -> color}}', 
                size: '{{$listing->details->first()->size}}', 
                quantity:1,
                availability : {{json_encode($availableOption)}},
                handleClick(){
                    let availability = this.availability;
                    let currentDetailId = ''
                    for(let i = 0; i < availability.length; ++i){
                        if(this.color === availability[i]['color'] && this.size === availability[i]['size']){
                            currentDetailId = availability[i]['detailId'];
                            break;
                        }
                    }
                    $store.cart.addToCart({
                        'listingId' : {{$listing->id}},
                        'detailId' : currentDetailId,
                        'name' : '{{$listing->name}}',
                        'color' : this.color,
                        'size' : this.size, 
                        'quantity' : this.quantity,
                        'price' : {{$listing->selling_price}},
                        'imageURL' : '{{$listing -> details -> first() -> images -> first() -> imageURL}}',
                    })
                },
                showAvailableOption(selectedValue, mainOption, otherOption, mainOptionKey, otherOptionKey){
                    let availability = this.availability;

                    let availableOption = [];
                    for(let i = 0; i < availability.length; ++i){
                        if(selectedValue == availability[i][mainOptionKey] && availability[i]['available']){
                            availableOption.push(availability[i][otherOptionKey])
                        }
                    }
                    let children = otherOption.children;
                    console.log(availableOption);
                    for(let i = 0; i < children.length; ++i){
                        let input = children[i].children[0];
                        input.disabled = false;
                        let inputValue = children[i].children[0].value;
                        if(!availableOption.includes(inputValue)){
                            input.checked = false;
                            input.classList.toggle('bg-red-500');
                        }
                        else{
                            input.checked = true;
                            //Set the model to correct data
                            if(mainOptionKey === 'color'){
                                this.size = inputValue;
                            }else{
                                this.color = inputValue;
                            }
                        }
                    }
                    console.log(this.color, this.size);

                    setTimeout(() => {
                        for(let i = 0; i < children.length; ++i){
                            let input = children[i].children[0];
                            input.disabled = false;
                        }
                    }, 5000);
                }
            }">
                <div class='col-start-1 h-full'>            
                    <x-card.image-gallery class='!w-full !h-full' :listing="$listing" cover="bg-white drop-shadow-md p-2 h-60 mb-2"></x-card.image-gallery>
                </div>
                <div>
                    <div class="bg-white drop-shadow-md p-2">
                        <h4 class="w-full font-semibold">{{$listing -> name}}</h4>
                        <div  class="flex gap-x-4 flex-wrap">  
                            <div class="flex-grow">
                                <p>Size</p> 
                                {{-- <select x-ref="size" name="size" id="size-id" x-model="size" class="w-full" :change="showAvailableColor"> --}}
                                <div x-ref="size" class="flex gap-2">
                                    @foreach ($listing -> details as $detail) 
                                        <div x-id="['size']" class="flex items-center ps-2 border-gray-200 rounded border">
                                            <input type="radio" x-model="size" :id="$id('size')" value="{{$detail->size}}" @change="showAvailableOption(size, $refs.size, $refs.color, 'size', 'color')"
                                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 disabled:opacity-50" 
                                            > 
                                            <label :for="$id('size')"
                                                    class="w-full p-2 text-sm font-medium text-gray-900"
                                            >{{$detail->size}}</label>
                                        </div>
                                    @endforeach 
                                </div>
                                {{-- </select> --}}
                            </div>
                            <div class="flex-grow">
                                <p>color</p> 
                                {{-- <select x-ref="size" name="size" id="size-id" x-model="size" class="w-full" :change="showAvailableColor"> --}}
                                <div x-ref="color" class="flex gap-2">
                                    @foreach ($listing -> details as $detail) 
                                        <div x-id="['color']" class="flex items-center ps-2 border-gray-200 rounded border">
                                            <input type="radio" x-model="color" :id="$id('color')" value="{{$detail->color}}" @change="showAvailableOption(color, $refs.color, $refs.size, 'color', 'size')"
                                                    class="text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 disabled:opacity-50"
                                            > 
                                            <label :for="$id('color')"
                                                    class="w-full p-2 text-sm font-sm"
                                            >{{$detail->color}}</label>
                                        </div>
                                    @endforeach 
                                </div>
                                {{-- </select> --}}
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
                    <button @click="handleClick"
                        class="p-2 bg-black rounded-md font-medium text-white mt-2"
                    >Add to cart</button>
                </div>
            </div>
        @auth
            <a href="/listings/{{$listing->id}}/edit" class="mb-4"><x-button>Edit</x-button></a> 
            <x-form.delete-button url="/listings/{{$listing->id}}" name="Delete listing"/>
        @endauth

        </div>
    {{-- <a href="/">Return</a> --}}
    </main>
</x-layout>