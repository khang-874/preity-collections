@props(['name', 'otherName', 'details', 'listing'])
@php
    $count = 0;
    $availableOption = [];
    foreach($details as $detail){
        $availableOption[]=  array(
            "detailId" => $detail -> id,
            "color" => $detail -> color,
            "size" => $detail -> size,
            "available" => $detail -> available
    );
    }

    $colors = [];
    $sizes = [];
    foreach($details as $detail){
        if(!array_key_exists($detail -> color, $colors))
            $colors[$detail -> color] = 0;
        if(!array_key_exists($detail -> size, $sizes))
            $sizes[$detail -> size] = 0;

        $colors[$detail -> color] += $detail -> inventory;
        $sizes[$detail -> size] += $detail -> inventory;
    }

    $initialColor = '';
    $initialSize = '';
    foreach($colors as $color => $quantity){
        if($quantity != 0){
            $initialColor = $color;
            break;
        }
    }

    foreach($sizes as $size => $quantity){
        if($quantity != 0){
            $initialSize = $size;
            break;
        }
    }

@endphp

<div x-data="{
    color: '{{$initialColor}}', 
    size: '{{$initialSize}}', 
    quantity:1,
    availability : {{json_encode($availableOption)}},
    handleClick(){
        let availability = this.availability;
        let currentDetailId = ''
        for(let i = 0; i < availability.length; ++i){
            if(this.color === availability[i]['color'] && this.size === availability[i]['size'] && availability[i]['available']){
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
            'imageURL' : '{{$listing -> images[0] ?? ''}}',
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
        let children = mainOption.children;

        for(let i = 0; i < children.length;++i){
            let inputValue = children[i].children[0].value;
            if(selectedValue == inputValue){
                children[i].classList.remove('opacity-50');
            }else{
                children[i].classList.add('opacity-50');
            }
        }

        children = otherOption.children;
        for(let i = 0; i < children.length; ++i){
            let inputValue = children[i].children[0].value;

            if(!availableOption.includes(inputValue)){
                children[i].classList.add('opacity-50');
                {{-- children[i].classList.add('opacity-50 after:absolute after:left-0 after:top-1/2 after:h-[1px] after:bg-black after:w-full after:block'); --}}
            }
            else{
                children[i].classList.remove('opacity-50');
                //Set the model to correct data
                if(mainOptionKey === 'color'){
                    this.size = inputValue;
                }else{
                    this.color = inputValue;
                }
            }
        }
    }
}" 
    x-init="showAvailableOption({{$initialColor}}, $refs.size, $refs.color, 'size', 'color')"
    class=" mt-4 grid grid-rows-2 gap-y-1">
    <div class="">
        <p class="mb-1">Select size:</p> 
        <div x-ref="size" class="flex gap-2 flex-wrap ml-2">
            @foreach ($sizes as $size => $quantity) 
                @if($quantity != 0)
                    <div x-id="['size']" class="flex items-center ps-2 border-gray-200 rounded border relative">
                        <input type="radio" x-model="size" :id="$id('size')" value="{{$size}}" @change="showAvailableOption(size, $refs.size, $refs.color, 'size', 'color')"
                                class="text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 disabled:opacity-50"
                        > 
                        <label :for="$id('size')"
                                class="w-full p-2 text-sm font-sm"
                        >{{$size}}</label>
                    </div>
                @endif
            @endforeach 
        </div>
    </div>

    <div class="">
        <p class="mb-1">Select color:</p> 
        <div x-ref="color" class="flex gap-2 flex-wrap ml-2">
            @foreach ($colors as $color => $quantity) 
                @if($quantity != 0)
                    <div x-id="['color']" class="flex items-center ps-2 border-gray-200 rounded border relative">
                        <input type="radio" x-model="color" :id="$id('color')" value="{{$color}}" @change="showAvailableOption(color, $refs.color, $refs.size, 'color', 'size')"
                                class="text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 disabled:opacity-50"
                        > 
                        <label :for="$id('color')"
                                class="w-full p-2 text-sm font-sm"
                        >{{$color}}</label>
                    </div>
                @endif
            @endforeach 
        </div>
    </div>
    <div class="flex gap-2 basis-[100%]">
        <label for="quantity" class="">Quantity:</label>
        <div class="flex items-center ">
            <button @click="quantity++" class="flex items-center"><i class="fa-solid fa-plus"></i></button>
            <input type="number" x-model.number="quantity" id="quantity" class="w-8 text-center"/>
            <button @click="() => {if(quantity > 1)quantity--;}" 
                    class="flex items-center"><i class="fa-solid fa-minus"></i></button>
        </div>
    </div>

    <button @click="handleClick" class="p-2 bg-blue-600 rounded-md font-medium text-white gap-2 flex-grow">   
        <i class="fa-solid fa-cart-shopping" ></i>
        Add to cart
    </button>
</div>